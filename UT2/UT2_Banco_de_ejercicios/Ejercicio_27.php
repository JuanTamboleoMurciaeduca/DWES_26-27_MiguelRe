<?php
    declare(strict_types=1);

    $libros = [
        ['id' => 1, 'titulo' => 'Dune', 'paginas' => 412],
        ['id' => 2, 'titulo' => 'It', 'paginas' => 1504],
    ];

    $busqueda = mb_strtolower(trim('  DUNE '), 'UTF-8');

    $visibles = array_filter(
        $libros,
        fn (array $l): bool => str_contains(
            mb_strtolower($l['titulo'], 'UTF-8'),
            $busqueda
        )
    );

    usort($libros, fn (array $a, array $b): int => $a['paginas'] <=> $b['paginas']);

    $titulos = array_column($libros, 'titulo');

    $etiquetas = array_map(fn (string $t): string => "Libro: $t", $titulos);

    echo 'Búsqueda normalizada: ' . $busqueda . '<br>';

    echo '<br>Visibles:<br>';
    foreach ($visibles as $libro) {
        echo $libro['titulo'] . '<br>';
    }

    echo '<br>Etiquetas ordenadas por páginas:<br>';
    foreach ($etiquetas as $etiqueta) {
        echo $etiqueta . '<br>';
    }

    $libroId2 = array_find($libros, fn (array $l): bool => $l['id'] === 2);

    echo '<br>';
    if ($libroId2 !== null) {
        echo 'Libro con id 2: ' . $libroId2['titulo'] . ' (' . $libroId2['paginas'] . ' páginas)';
    } else {
        echo 'No hay libro con id 2';
    }
?>