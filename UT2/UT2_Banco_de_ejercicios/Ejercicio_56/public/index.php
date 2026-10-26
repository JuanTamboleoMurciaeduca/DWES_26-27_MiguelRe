<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Model\Libro;
    use App\Repository\ArrayLibroRepository;
    use App\Service\CatalogoService;

    function mostrarTitulos(array $titulos): void
    {
        if ($titulos === []) {
            echo 'Sin libros disponibles' . PHP_EOL;
            return;
        }

        foreach ($titulos as $titulo) {
            echo $titulo . PHP_EOL;
        }
    }

    $libros = [
        new Libro(10, 'Dune', true),
        new Libro(20, 'Solaris', false),
        new Libro(30, 'Drácula', true),
    ];

    $servicio = new CatalogoService(new ArrayLibroRepository($libros));

    echo 'Catálogo con libros:' . PHP_EOL;
    mostrarTitulos($servicio->titulosDisponibles());

    $servicioVacio = new CatalogoService(new ArrayLibroRepository([]));

    echo PHP_EOL . 'Catálogo vacío:' . PHP_EOL;
    mostrarTitulos($servicioVacio->titulosDisponibles());
?>
