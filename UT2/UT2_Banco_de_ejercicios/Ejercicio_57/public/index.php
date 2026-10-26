<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Exception\LibroNoDisponibleException;
    use App\Model\Libro;
    use App\Repository\ArrayLibroRepository;
    use App\Service\CatalogoService;

    function mostrarDisponibles(CatalogoService $servicio): void
    {
        $titulos = $servicio->titulosDisponibles();

        echo 'Disponibles: ' . ($titulos === [] ? 'ninguno' : implode(', ', $titulos)) . PHP_EOL;
    }

    $libros = [
        new Libro(10, 'Dune', true),
        new Libro(20, 'Solaris', false),
        new Libro(30, 'Drácula', true),
    ];

    $servicio = new CatalogoService(new ArrayLibroRepository($libros));

    mostrarDisponibles($servicio);

    $servicio->prestarPorId(10);
    echo 'Préstamo del id 10 realizado' . PHP_EOL;

    mostrarDisponibles($servicio);

    echo 'Dune en la colección inicial, estaDisponible(): ' . ($libros[0]->estaDisponible() ? 'true' : 'false') . PHP_EOL;

    try {
        $servicio->prestarPorId(10);
    } catch (LibroNoDisponibleException $e) {
        echo 'Rechazado: ' . $e->getMessage() . PHP_EOL;
    }

    try {
        $servicio->prestarPorId(99);
    } catch (InvalidArgumentException $e) {
        echo 'Rechazado: ' . $e->getMessage() . PHP_EOL;
    }

    mostrarDisponibles($servicio);
?>
