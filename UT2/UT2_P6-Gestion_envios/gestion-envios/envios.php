<?php
    declare(strict_types=1);

    require_once __DIR__ . '/vendor/autoload.php';

    use App\Excepcion\EnvioException;
    use App\Modelo\EnvioNormal;
    use App\Modelo\EnvioUrgente;
    use App\Modelo\EstadoEnvio;
    use App\Repositorio\RepositorioEnviosMemoria;
    use App\Servicio\ServicioEnvios;

    $envios = [
        new EnvioNormal(101, 'Librería Órbita', 1000, EstadoEnvio::Pendiente),
        new EnvioUrgente(102, 'Taller Norte', 1500, EstadoEnvio::Enviado),
        new EnvioNormal(103, 'Café Álamo', 2500, EstadoEnvio::Entregado),
        new EnvioUrgente(104, 'Estudio Prisma', 500, EstadoEnvio::Cancelado),
        new EnvioNormal(105, 'Papelería Sol', 2000, EstadoEnvio::Pendiente),
        new EnvioUrgente(106, 'Órbita Creativa', 1001, EstadoEnvio::Pendiente),
    ];

    $repositorio = new RepositorioEnviosMemoria();

    foreach ($envios as $envio) {
        $repositorio->registrar($envio);
    }

    $servicio = new ServicioEnvios($repositorio);

    echo "=== 5.1 Catálogo inicial ===\n";
    foreach ($servicio->etiquetas($repositorio->todos()) as $etiqueta) {
        echo $etiqueta . "\n";
    }
    print_r($servicio->resumir($repositorio->todos()));

    $consultas = [
        ['', null, null, 'precio'],
        [' ÓRBITA ', null, null, 'precio'],
        ['', 'urgente', null, 'precio'],
        ['', null, EstadoEnvio::Pendiente, 'precio'],
        ['ÓRBITA', 'urgente', EstadoEnvio::Pendiente, 'precio'],
        [' ÓRBITA CREATIVA ', null, null, 'precio'],
        ['xyz', null, null, 'precio'],
        ['', null, null, 'peso'],
    ];

    echo "\n=== 5.2 Consultas ===\n";
    foreach ($consultas as [$texto, $modalidad, $estado, $orden]) {
        $resultado = $servicio->consultar($texto, $modalidad, $estado, $orden);

        echo "\nConsulta: texto '$texto', modalidad " . ($modalidad ?? 'cualquiera')
            . ', estado ' . ($estado?->value ?? 'cualquiera') . ", orden $orden\n";

        if ($resultado === []) {
            echo "Sin resultados\n";
        }
        foreach ($servicio->etiquetas($resultado) as $etiqueta) {
            echo $etiqueta . "\n";
        }
        print_r($servicio->resumir($resultado)); // una vez por consulta (con [] sale todo a 0)
    }

    echo "\nOrden del repositorio: ";
    foreach ($repositorio->todos() as $envio) {
        echo $envio->id() . ' ';
    }
    echo "\n";
    print_r($servicio->resumir($repositorio->todos()));

    $primera = $repositorio->buscar(101);
    $segunda = $repositorio->buscar(101);
    echo $primera === $segunda ? "Misma instancia\n" : "Instancias distintas\n";

    $operaciones = [
        ['enviar', 101],
        ['cancelar', 101],
        ['entregar', 101],
        ['enviar', 101],
        ['cancelar', 105],
        ['enviar', 105],
        ['entregar', 102],
        ['cancelar', 104],
        ['entregar', 106],
        ['enviar', 999],
    ];

    echo "\n=== 6.1 Operaciones ===\n";
    foreach ($operaciones as [$accion, $id]) {
        try {
            $servicio->$accion($id); // llama a enviar(), entregar() o cancelar()
            echo "$accion $id: OK\n";
        } catch (EnvioException $error) {
            echo "$accion $id: RECHAZADO - " . $error->getMessage() . "\n";
        }

        $envio = $repositorio->buscar($id);
        if ($envio !== null) {
            echo "   Estado actual: " . $envio->estado()->value . "\n";
        }
    }

    echo "\nResumen final:\n";
    print_r($servicio->resumir($repositorio->todos()));

    echo "Pendientes:\n";
    foreach ($servicio->etiquetas($servicio->consultar('', null, EstadoEnvio::Pendiente)) as $etiqueta) {
        echo $etiqueta . "\n";
    }

    echo "\n=== 6.2.1 Construcciones inválidas ===\n";
    $invalidos = [
        'id 0'             => fn () => new EnvioNormal(0, 'Cliente', 1000, EstadoEnvio::Pendiente),
        'id -1'            => fn () => new EnvioNormal(-1, 'Cliente', 1000, EstadoEnvio::Pendiente),
        'cliente vacío'    => fn () => new EnvioNormal(201, '', 1000, EstadoEnvio::Pendiente),
        'cliente espacios' => fn () => new EnvioNormal(202, '   ', 1000, EstadoEnvio::Pendiente),
        'peso 0'           => fn () => new EnvioNormal(203, 'Cliente', 0, EstadoEnvio::Pendiente),
        'peso -1'          => fn () => new EnvioNormal(204, 'Cliente', -1, EstadoEnvio::Pendiente),
        'peso 20001'       => fn () => new EnvioNormal(205, 'Cliente', 20001, EstadoEnvio::Pendiente),
    ];

    foreach ($invalidos as $caso => $crear) {
        try {
            $crear();
            echo "$caso: NO se rechazó (error)\n";
        } catch (InvalidArgumentException $error) {
            echo "$caso: rechazado - " . $error->getMessage() . "\n";
        }
    }

    echo "\n=== 6.2.2 Espacios y tarifas límite ===\n";
    $conEspacios = new EnvioNormal(301, '   Mi   Tienda  ', 1000, EstadoEnvio::Pendiente);
    echo "Cliente guardado: [" . $conEspacios->cliente() . "]\n"; // [Mi   Tienda]

    $pesosLimite = [1, 1000, 1001, 20000];
    $idLimite = 400;
    foreach ($pesosLimite as $pesoLimite) {
        $normal = new EnvioNormal(++$idLimite, 'Limite', $pesoLimite, EstadoEnvio::Pendiente);
        $urgente = new EnvioUrgente(++$idLimite, 'Limite', $pesoLimite, EstadoEnvio::Pendiente);
        echo "Peso $pesoLimite g: normal " . $normal->tarifa() . ", urgente " . $urgente->tarifa() . "\n";
    }

    echo "\n=== 6.2.3 Id duplicado ===\n";
    try {
        $repositorio->registrar(new EnvioNormal(101, 'Duplicado', 500, EstadoEnvio::Pendiente));
        echo "Duplicado: NO se rechazó (error)\n";
    } catch (EnvioException $error) {
        echo "Duplicado rechazado - " . $error->getMessage() . "\n";
    }
    echo "Envíos en el repositorio: " . count($repositorio->todos()) . "\n";
    echo $repositorio->buscar(101) === $envios[0] ? "Conserva la instancia anterior\n" : "La instancia cambió (error)\n";

    echo "\n=== 6.2.4 Búsquedas por id ===\n";
    echo "buscar(999): ";
    var_dump($repositorio->buscar(999));

    try {
        $repositorio->buscar(0);
        echo "buscar(0): NO se rechazó (error)\n";
    } catch (InvalidArgumentException $error) {
        echo "buscar(0) rechazado - " . $error->getMessage() . "\n";
    }

    try {
        $servicio->enviar(0);
        echo "enviar(0): NO se rechazó (error)\n";
    } catch (InvalidArgumentException $error) {
        echo "enviar(0) rechazado - " . $error->getMessage() . "\n";
    }
    echo "Envíos en el repositorio: " . count($repositorio->todos()) . "\n";

    echo "\n=== 6.2.5 Consultas inválidas y colecciones vacías ===\n";
    $servicioVacio = new ServicioEnvios(new RepositorioEnviosMemoria());
    $servicios = ['con datos' => $servicio, 'vacío' => $servicioVacio];

    foreach ($servicios as $nombre => $servicioProbado) {
        try {
            $servicioProbado->consultar('', 'rapido');
            echo "[$nombre] modalidad desconocida: NO se rechazó (error)\n";
        } catch (InvalidArgumentException $error) {
            echo "[$nombre] modalidad desconocida rechazada - " . $error->getMessage() . "\n";
        }

        try {
            $servicioProbado->consultar('', null, null, 'color');
            echo "[$nombre] orden desconocido: NO se rechazó (error)\n";
        } catch (InvalidArgumentException $error) {
            echo "[$nombre] orden desconocido rechazado - " . $error->getMessage() . "\n";
        }
    }

    echo "Consulta válida en el repositorio vacío: ";
    var_dump($servicioVacio->consultar());
    echo "etiquetas([]): ";
    var_dump($servicio->etiquetas([]));
    echo "resumir([]):\n";
    print_r($servicio->resumir([]));
?>