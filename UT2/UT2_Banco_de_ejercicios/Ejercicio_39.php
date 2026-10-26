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

    function buscarEtiquetas(array $libros, string $texto): array
    {
        $busqueda = mb_strtolower(trim($texto), 'UTF-8');

        $encontrados = array_filter(
            $libros,
            fn (Libro $libro): bool => str_contains(mb_strtolower($libro->titulo, 'UTF-8'), $busqueda)
        );

        return array_map(
            fn (Libro $libro): string => $libro->titulo . ' - ' . $libro->paginas . ' páginas',
            $encontrados
        );
    }

    function mostrarEtiquetas(array $etiquetas): void
    {
        if ($etiquetas === []) {
            echo 'Sin resultados<br>';
            return;
        }

        foreach ($etiquetas as $etiqueta) {
            echo $etiqueta . '<br>';
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

    echo 'Búsqueda " DRÁ ":<br>';
    mostrarEtiquetas(buscarEtiquetas($libros, ' DRÁ '));

    echo '<br>Búsqueda "xyz":<br>';
    mostrarEtiquetas(buscarEtiquetas($libros, 'xyz'));
?>
