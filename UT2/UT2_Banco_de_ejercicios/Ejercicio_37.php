<?php
    declare(strict_types=1);

    final class Libro
    {
        public function __construct(
            public string $titulo,
            public int $paginas,
        ) {
            if (trim($titulo) === '' || $paginas <= 0) {
                throw new InvalidArgumentException('El título no puede estar vacío y las páginas deben ser mayores que cero.');
            }
        }
    }

    $caso = $_GET['caso'] ?? $argv[1] ?? '1';

    $libro = match ($caso) {
        '1' => new Libro('Dune', 412),
        '2' => new Libro(' ', 100),
        '3' => new Libro('Solaris', 0),
        '4' => new Libro('Solaris', -5),
        default => null,
    };

    if ($libro !== null) {
        echo 'Caso ' . $caso . ': creado ' . $libro->titulo . ' - ' . $libro->paginas . ' páginas<br>';

        $libro->paginas = 0;

        echo 'Después de asignar 0 desde fuera: ' . $libro->paginas . ' páginas<br>';
    } else {
        echo 'Caso no válido. Usa ?caso=1, ?caso=2, ?caso=3 o ?caso=4';
    }
?>
