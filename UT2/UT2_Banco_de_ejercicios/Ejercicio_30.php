<?php
    declare(strict_types=1);

    final class Libro
    {
        public function __construct(
            public string $titulo,
            public bool $disponible = true,
        ) {
        }
    }

    $dune = new Libro('Dune');
    $solaris = new Libro('Solaris', false);

    echo $dune->titulo . ': ' . ($dune->disponible ? 'disponible' : 'no disponible') . '<br>';
    echo $solaris->titulo . ': ' . ($solaris->disponible ? 'disponible' : 'no disponible') . '<br>';
?>