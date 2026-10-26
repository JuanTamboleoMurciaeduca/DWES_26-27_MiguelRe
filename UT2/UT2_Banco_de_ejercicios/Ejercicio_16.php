<?php
    declare(strict_types=1);

    $texto = 'Desarrollo Web con PHP';

    if (str_contains($texto, 'PHP')) {
        echo 'El texto contiene PHP<br>';
    } else {
        echo 'El texto no contiene PHP<br>';
    }

    $posicion = strpos($texto, 'PHP');

    if ($posicion !== false) {
        echo 'PHP aparece en la posición ' . $posicion . '<br>';
    } else {
        echo 'PHP no aparece<br>';
    }

    $posicionInicio = strpos($texto, 'Desarrollo');

    if ($posicionInicio !== false) {
        echo 'Desarrollo aparece en la posición ' . $posicionInicio . '<br>';
    } else {
        echo 'Desarrollo no aparece<br>';
    }

    if ($posicionInicio) {
        echo 'Con if ($posicionInicio) sí se encuentra<br>';
    } else {
        echo 'Con if ($posicionInicio) parece que no se encuentra, porque 0 se evalúa como false<br>';
    }
?>