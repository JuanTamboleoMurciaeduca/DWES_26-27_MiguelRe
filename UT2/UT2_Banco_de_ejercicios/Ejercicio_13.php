<?php
    declare(strict_types=1);

    $libros = [
        ['id' => 1, 'titulo' => '1984', 'genero' => 'distopia'],
        ['id' => 2, 'titulo' => 'El principito', 'genero' => 'fantasia'],
        ['id' => 3, 'titulo' => 'Fahrenheit 451', 'genero' => 'ciencia ficcion'],
        ['id' => 4, 'titulo' => 'El nombre del viento', 'genero' => 'fantasia'],
        ['id' => 5, 'titulo' => 'Dune', 'genero' => 'ciencia ficcion'],
    ];

    $generos = array_column($libros, 'genero');
    $generosUnicos = array_unique($generos);

    foreach ($generosUnicos as $clave => $genero) {
        echo $clave . ': ' . $genero . '<br>';
    }

    echo '<br>';

    $claves = ['id', 'titulo', 'autor', 'paginas'];
    $valores = [5, 'Dune', 'Frank Herbert', 412];

    $libro = array_combine($claves, $valores);

    foreach ($libro as $clave => $valor) {
        echo $clave . ': ' . $valor . '<br>';
    }
?>