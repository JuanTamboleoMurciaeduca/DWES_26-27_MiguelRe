<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Model\Libro;
    use App\Model\Revista;
    use App\Service\ListadoService;

    $recursos = [
        new Libro('Dune'),
        new Revista('Ciencia'),
        new Revista('Historia'),
    ];

    $servicio = new ListadoService();

    foreach ($servicio->lineas($recursos) as $linea) {
        echo $linea . PHP_EOL;
    }
?>
