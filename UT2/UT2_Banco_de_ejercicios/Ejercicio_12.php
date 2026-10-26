<?php
    declare(strict_types=1);

    $libros = [
        ['id' => 10, 'titulo' => 'Dune', 'paginas' => 412],
        ['id' => 20, 'titulo' => 'Drácula', 'paginas' => 418],
        ['id' => 30, 'titulo' => '1984', 'paginas' => 328],
    ];

    // Obtener un array solo con los títulos
    $titulos = array_column($libros, "titulo");
    print_r($titulos);

    // Crear un array indexado por id con los registros completos
    $librosPorId = array_column($libros, null, "id");
    print_r($librosPorId);
?>