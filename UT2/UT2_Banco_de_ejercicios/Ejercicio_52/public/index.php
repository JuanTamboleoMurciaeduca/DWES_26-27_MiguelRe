<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Model\Categoria;
    use App\Model\Libro;
    use App\Model\Personas\Autor;
    use App\Importacion\Libro as LibroImportado;
    use App\Service\CatalogoService;

    $dune = new Libro('Dune', new Autor('Frank Herbert'));
    $solaris = new Libro('Solaris', new Autor('Stanislaw Lem'));
    $hobbit = new LibroImportado('El Hobbit');
    $categoria = new Categoria('Ciencia ficción');

    echo $dune->ficha() . PHP_EOL;
    echo $hobbit->titulo() . PHP_EOL;
    echo $categoria->nombre() . PHP_EOL;

    echo PHP_EOL . 'Fichas del servicio:' . PHP_EOL;

    $servicio = new CatalogoService([$dune, $solaris]);

    foreach ($servicio->fichas() as $ficha) {
        echo $ficha . PHP_EOL;
    }

    echo PHP_EOL . 'Fichas del servicio vacío:' . PHP_EOL;

    $servicioVacio = new CatalogoService([]);

    foreach ($servicioVacio->fichas() as $ficha) {
        echo $ficha . PHP_EOL;
    }
?>
