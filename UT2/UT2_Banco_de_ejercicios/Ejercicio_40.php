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

    function mostrarColeccion(array $libros): void
    {
        foreach ($libros as $clave => $libro) {
            echo $clave . ' => id ' . $libro->id . ' | ' . $libro->titulo . ' | ' . $libro->paginas . ' páginas<br>';
        }
    }

    $libros = array_map(
        fn (array $registro): Libro => new Libro(
            $registro['id'],
            $registro['titulo'],
            $registro['paginas'],
            $registro['disponible'],
        ),
        $datos
    );

    usort($libros, fn (Libro $a, Libro $b): int => $a->paginas <=> $b->paginas);

    echo 'Ascendente:<br>';
    mostrarColeccion($libros);

    $total = array_reduce(
        $libros,
        fn (int $acumulado, Libro $libro): int => $acumulado + $libro->paginas,
        0
    );

    echo '<br>Total de páginas: ' . $total . '<br>';

    usort($libros, fn (Libro $a, Libro $b): int => $b->paginas <=> $a->paginas);

    echo '<br>Descendente:<br>';
    mostrarColeccion($libros);
?>
