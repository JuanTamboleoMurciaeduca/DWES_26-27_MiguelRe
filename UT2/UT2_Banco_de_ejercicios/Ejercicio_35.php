<?php
    declare(strict_types=1);

    final class Autor
    {
        public function __construct(public string $nombre)
        {
        }
    }

    final class Categoria
    {
        public function __construct(public string $nombre)
        {
        }
    }

    final class Libro
    {
        public function __construct(
            public string $titulo,
            public Autor $autor,
            public Categoria $categoria,
        ) {
        }
    }

    $autor = new Autor('Frank Herbert');
    $categoria = new Categoria('Ciencia ficción');

    $dune = new Libro('Dune', $autor, $categoria);

    echo 'Título: ' . $dune->titulo . '<br>';
    echo 'Autor: ' . $dune->autor->nombre . '<br>';
    echo 'Categoría: ' . $dune->categoria->nombre . '<br>';
?>
