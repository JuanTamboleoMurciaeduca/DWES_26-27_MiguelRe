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

        public function prestar(): void
        {
            $this->disponible = false;
        }

        public function devolver(): void
        {
            $this->disponible = true;
        }
    }

    function siNo(bool $valor): string
    {
        return $valor ? 'true' : 'false';
    }

    function titulos(array $libros): string
    {
        return implode(', ', array_map(fn (Libro $libro): string => $libro->titulo, $libros));
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

    $disponibles = array_filter($libros, fn (Libro $libro): bool => $libro->disponible);

    echo 'Disponibles antes del préstamo: ' . titulos($disponibles) . '<br><br>';

    $encontrado = array_find($libros, fn (Libro $libro): bool => $libro->id === 10);

    if ($encontrado !== null) {
        $encontrado->prestar();
    }

    echo 'disponible del resultado de array_find: ' . siNo($encontrado->disponible) . '<br>';
    echo 'disponible de Dune en la colección completa: ' . siNo($libros[0]->disponible) . '<br>';
    echo 'disponible de Dune en la lista filtrada antes: ' . siNo($disponibles[0]->disponible) . '<br>';
    echo 'Mismo objeto en las tres: ' . siNo($encontrado === $libros[0] && $libros[0] === $disponibles[0]) . '<br><br>';

    echo 'Lista filtrada antes (sin actualizar): ' . titulos($disponibles) . '<br>';

    $disponiblesActualizados = array_filter($libros, fn (Libro $libro): bool => $libro->disponible);

    echo 'Lista filtrada de nuevo: ' . titulos($disponiblesActualizados) . '<br><br>';

    $noExiste = array_find($libros, fn (Libro $libro): bool => $libro->id === 99);

    echo 'Búsqueda id 99: ' . ($noExiste?->titulo ?? 'Libro no encontrado') . '<br>';
?>
