<?php
    declare(strict_types=1);

    final class Autor
    {
        public function __construct(public string $nombre)
        {
        }
    }

    final class Libro
    {
        public function __construct(
            public string $titulo,
            public ?Autor $autor = null,
        ) {
        }
    }

    $conAutor = new Libro('Dune', new Autor('Frank Herbert'));
    $sinAutor = new Libro('Relato anónimo');

    echo $conAutor->titulo . ': ' . ($conAutor->autor?->nombre ?? 'Sin autor') . '<br>';
    echo $sinAutor->titulo . ': ' . ($sinAutor->autor?->nombre ?? 'Sin autor') . '<br>';
?>
