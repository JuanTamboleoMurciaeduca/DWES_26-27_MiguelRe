<?php
    declare(strict_types=1);

    $generos = ['terror', 'fantasía', 'ciencia ficción', 'novela negra'];

    $resultado = array_search("terror", $generos, true);

    if ($resultado !== false) {
        echo "Género encontrado en la clave: " . $resultado;
    } else {
        echo "Género no encontrado";
    }
?>