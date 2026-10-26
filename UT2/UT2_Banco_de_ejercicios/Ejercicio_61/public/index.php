<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Exception\LibroNoDisponibleException;
    use App\Model\Libro;
    use App\Repository\ArrayLibroRepository;
    use App\Service\CatalogoService;

    function mostrar(string $encabezado, array $libros): void
    {
        echo $encabezado . PHP_EOL;

        if ($libros === []) {
            echo '  Sin resultados' . PHP_EOL;
        }

        foreach ($libros as $libro) {
            echo '  ' . $libro->titulo() . ' (' . $libro->paginas() . ' páginas)' . PHP_EOL;
        }

        echo PHP_EOL;
    }

    $libros = [
        new Libro(10, 'Dune', 412, true),
        new Libro(20, 'Solaris', 216, false),
        new Libro(30, 'Drácula', 418, true),
        new Libro(40, 'El Hobbit', 310, true),
    ];

    $servicio = new CatalogoService(new ArrayLibroRepository($libros));

    mostrar('Búsqueda vacía, máximo 500:', $servicio->buscarDisponibles('', 500));
    mostrar('Búsqueda " DRÁ ", máximo 500:', $servicio->buscarDisponibles(' DRÁ ', 500));
    mostrar('Búsqueda "xyz", máximo 500:', $servicio->buscarDisponibles('xyz', 500));

    $servicio->prestarPorId(10);
    echo 'Préstamo del id 10 realizado' . PHP_EOL;

    try {
        $servicio->prestarPorId(10);
    } catch (LibroNoDisponibleException $e) {
        echo 'Rechazado: ' . $e->getMessage() . PHP_EOL;
    }

    echo PHP_EOL;
    mostrar('Tras el préstamo, búsqueda vacía, máximo 500:', $servicio->buscarDisponibles('', 500));

    $servicio->devolverPorId(10);
    echo 'Devolución del id 10 realizada' . PHP_EOL . PHP_EOL;

    mostrar('Tras la devolución, búsqueda vacía, máximo 500:', $servicio->buscarDisponibles('', 500));

    try {
        $servicio->prestarPorId(99);
    } catch (InvalidArgumentException $e) {
        echo 'Rechazado: ' . $e->getMessage() . PHP_EOL;
    }

    try {
        $servicio->buscarDisponibles('', 0);
    } catch (InvalidArgumentException $e) {
        echo 'Rechazado: ' . $e->getMessage() . PHP_EOL;
    }
?>
