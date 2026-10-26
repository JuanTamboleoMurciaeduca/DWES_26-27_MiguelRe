<?php
    declare(strict_types=1);

    $datos = [
        ['id' => 10, 'titulo' => 'Dune', 'paginas' => 412, 'disponible' => true],
        ['id' => 20, 'titulo' => 'Drácula', 'paginas' => 418, 'disponible' => false],
        ['id' => 30, 'titulo' => '1984', 'paginas' => 328, 'disponible' => true],
        ['id' => 40, 'titulo' => 'It', 'paginas' => 1504, 'disponible' => true],
    ];

    final class Libro
    {
        public function __construct(
            public int $id,
            public string $titulo,
            public int $paginas,
            public bool $disponible = true,
        ) {
        }
    }

    $libros = array_map(
        fn (array $registro): Libro => new Libro(
            titulo: $registro['titulo'],
            id: $registro['id'],
            disponible: $registro['disponible'],
            paginas: $registro['paginas'],
        ),
        $datos
    );

    foreach ($libros as $libro) {
        echo $libro->id . ' | ' . $libro->titulo . ' | ' . $libro->paginas . ' páginas<br>';
    }

    echo '<br>Objetos creados: ' . count($libros) . '<br>';
    echo 'Primer elemento de $libros: ' . get_debug_type($libros[0]) . '<br>';
    echo 'Primer elemento de $datos: ' . get_debug_type($datos[0]) . '<br>';
?>
