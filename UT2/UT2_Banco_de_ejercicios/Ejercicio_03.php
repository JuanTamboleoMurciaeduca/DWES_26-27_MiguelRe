<?php
    declare(strict_types=1);

    $factor = 4;

    $resultado = fn(int $n): int => $n * $factor;

    echo $resultado(4);
?>