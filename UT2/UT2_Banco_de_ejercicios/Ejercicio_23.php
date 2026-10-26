<?php
    declare(strict_types=1);

    function ficha(string $titulo, string $autor): string
    {
        return $titulo . ' - ' . $autor;
    }

    $texto = ficha(
        autor: 'Frank Herbert',
        titulo: 'Dune',
    );

    echo $texto;
?>