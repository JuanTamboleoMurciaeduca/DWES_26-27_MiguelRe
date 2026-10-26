<?php
    declare(strict_types=1);

    $iva = 0.21;

    $precioFinal = function(float $precio) use ($iva): float {
        return $precio * (1 + 0.21);
    };

    $total = $precioFinal(100);

    echo $total;
?>