<?php
    declare(strict_types=1);

    $catalogo = [
        ['titulo' => 'Dune', 'paginas' => 412],
        ['titulo' => 'Drácula', 'paginas' => 418],
        ['titulo' => '1984', 'paginas' => 328],
    ];

    $total = array_reduce(
        $catalogo,
        fn (int $acumulado, array $libro): int => $acumulado + $libro['paginas'],
        0
    );

    echo "Total de páginas: $total";
?>