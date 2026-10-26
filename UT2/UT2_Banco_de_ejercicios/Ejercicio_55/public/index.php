<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Model\Libro;
    use App\Service\CatalogoService;

    $servicio = new CatalogoService();

    $dune = new Libro('Dune');
    $solaris = new Libro('Solaris');

    echo $servicio->mostrar($dune) . PHP_EOL;
    echo $servicio->mostrar($solaris) . PHP_EOL;
?>
