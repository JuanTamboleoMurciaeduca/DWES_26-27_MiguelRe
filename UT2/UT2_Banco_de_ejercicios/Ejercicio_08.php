<?php
    declare(strict_types=1);


    $libros = [
        ['id' => 1, 'titulo' => 'Dune'],
        ['id' => 2, 'titulo' => 'Drácula'],
        ['id' => 3, 'titulo' => '1984'],
        ['id' => 4, 'titulo' => 'It'],
    ];

    $libro = array_find(
    $libros,
    fn (array $a): bool => $a['id'] === 3
    );

    print_r($libro);

    /*
    * Diferencia con array_filter:
    * array_find devuelve el primer elemento que cumple la condición (o null
    * si ninguno la cumple) y deja de recorrer en cuanto lo encuentra.
    * Y array_filter recorre todo el array y devuelve un array con todos los
    * elementos que cumplen, conservando sus claves (puede estar vacío).
    */
?>