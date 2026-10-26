<?php
    declare(strict_types=1);

    $catalogo = [
        ['titulo' => 'Dune', 'paginas' => 412],
        ['titulo' => 'Drácula', 'paginas' => 418],
        ['titulo' => '1984', 'paginas' => 328],
    ];

    $libros = array_map(
        fn (array $libro): string => $libro['titulo'] . " - " . $libro['paginas'] . " páginas",
        $catalogo
    );

    foreach ($libros as $libro) {
        echo $libro . "<br>";
    }
?>