<?php
    declare(strict_types=1);

    function mostrar(mixed $valor): string
    {
        if (is_bool($valor)) {
            return $valor ? 'true' : 'false';
        }

        return (string) $valor;
    }

    echo mostrar(true) . '<br>';
    echo mostrar(42) . '<br>';
    echo mostrar('Dune') . '<br>';
?>