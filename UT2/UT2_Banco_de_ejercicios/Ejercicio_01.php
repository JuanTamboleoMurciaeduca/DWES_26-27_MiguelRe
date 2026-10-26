<?php
    declare(strict_types=1);

    function doble(int $n): int
    {
        return $n * 2;
    }

    function cuadrado(int $n): int
    {
        return $n * $n;
    }

    function aplicar(int $n, callable $callback): int
    {
        return $callback($n);
    }

    $resultado = aplicar(5, 'doble'); // Aqui devolvería 10
    $resultado = aplicar(5, 'cuadrado'); // Aqui devolvería 25
?>