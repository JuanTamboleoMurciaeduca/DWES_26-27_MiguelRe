<?php
    declare(strict_types=1);

    $libros = [
        10 => ['titulo' => 'Dune', 'paginas' => 412],
        20 => ['titulo' => 'It', 'paginas' => 1504],
        30 => ['titulo' => '1984', 'paginas' => 328],
        40 => ['titulo' => 'El principito', 'paginas' => 96],
    ];

    echo 'Original:<br>';
    foreach ($libros as $clave => $libro) {
        echo $clave . ': ' . $libro['titulo'] . ' - ' . $libro['paginas'] . ' páginas<br>';
    }

    usort($libros, fn (array $a, array $b): int => $a['paginas'] <=> $b['paginas']);

    echo '<br>Ascendente:<br>';
    foreach ($libros as $clave => $libro) {
        echo $clave . ': ' . $libro['titulo'] . ' - ' . $libro['paginas'] . ' páginas<br>';
    }

    usort($libros, fn (array $a, array $b): int => $b['paginas'] <=> $a['paginas']);

    echo '<br>Descendente:<br>';
    foreach ($libros as $clave => $libro) {
        echo $clave . ': ' . $libro['titulo'] . ' - ' . $libro['paginas'] . ' páginas<br>';
    }
?>