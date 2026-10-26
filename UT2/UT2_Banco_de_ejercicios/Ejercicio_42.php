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

    function seleccionarDesdeEntrada(array $libros, mixed $entrada): array
    {
        $maximo = is_string($entrada) ? filter_var($entrada, FILTER_VALIDATE_INT) : false;

        if ($maximo === false || $maximo < 1) {
            echo 'Entrada no válida<br>';
            return [];
        }

        $seleccionados = array_filter(
            $libros,
            fn (Libro $libro): bool => $libro->disponible && $libro->paginas <= $maximo
        );

        if ($seleccionados === []) {
            echo 'Sin coincidencias<br>';
            return [];
        }

        $titulos = array_map(fn (Libro $libro): string => $libro->titulo, $seleccionados);

        $algunoMasDe400 = array_any($seleccionados, fn (Libro $libro): bool => $libro->paginas > 400);
        $todosPositivos = array_all($seleccionados, fn (Libro $libro): bool => $libro->paginas > 0);

        echo 'Títulos: ' . implode(', ', $titulos) . '<br>';
        echo 'Alguno con más de 400 páginas: ' . ($algunoMasDe400 ? 'sí' : 'no') . '<br>';
        echo 'Todos con páginas positivas: ' . ($todosPositivos ? 'sí' : 'no') . '<br>';

        return $seleccionados;
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

    $entradas = ['500', '0', 'abc', ['500'], '100'];

    foreach ($entradas as $entrada) {
        echo '<strong>Entrada ' . htmlspecialchars(var_export($entrada, true)) . '</strong><br>';
        $resultado = seleccionarDesdeEntrada($libros, $entrada);
        echo 'Objetos devueltos: ' . count($resultado) . '<br><br>';
    }

    echo 'Con (int) sin validar:<br>';
    echo '(int) "abc" = ' . (int) 'abc' . '<br>';
    echo '(int) "12abc" = ' . (int) '12abc' . '<br>';
?>
