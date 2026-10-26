<?php
    declare(strict_types=1);

    $ejemplares = [
        'Dune' => 3,
        'Drácula' => 0,
        '1984' => 2,
        'It' => 0,
    ];

    $libro = array_find_key(
        $ejemplares,
        fn($ejemplares) => $ejemplares === 0
    );

    print_r($libro);


    // Comprobar cuando ningún libro tiene 0 ejemplares
    $libros2 = [
        "Don Quijote" => 3,
        "El principito" => 2,
        "La Odisea" => 5
    ];

    $resultado = array_find_key(
        $libros2,
        fn($ejemplares) => $ejemplares === 0
    );

    echo PHP_EOL;
    var_dump($resultado);
?>