<?php
    declare(strict_types=1);

    $paginas = [412, 418, 328, 1504];

    $hayLargo = array_any(
        $paginas, 
        fn (int $p): bool => $p > 1000
    );

    $todosPositivos = array_all(
        $paginas, 
        fn (int $p): bool => $p > 0
    );

    echo '¿Algún libro con más de 1000 páginas? ' . ($hayLargo ? 'sí' : 'no') . PHP_EOL;
    echo '¿Todos tienen más de 0 páginas?   ' . ($todosPositivos ? 'sí' : 'no') . PHP_EOL;
?>