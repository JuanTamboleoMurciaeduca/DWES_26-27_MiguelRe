<?php
    declare(strict_types=1);

    final class Autor
    {
        public function __construct(
            public readonly string $nombre,
            public readonly string $codigo,
        ) {
        }
    }

    final class Categoria
    {
        public function __construct(private string $nombre)
        {
        }

        public function nombre(): string
        {
            return $this->nombre;
        }
    }

    final class Libro
    {
        public function __construct(
            private string $titulo,
            public readonly Autor $autor,
            public readonly Categoria $categoria,
        ) {
        }
    }

    $libro = new Libro('Dune', new Autor('Frank Herbert', 'AUT-01'), new Categoria('Ciencia ficción'));

    echo 'Categoría actual: ' . $libro->categoria->nombre() . '<br>';

    $libro->categoria = new Categoria('Narrativa');
?>
