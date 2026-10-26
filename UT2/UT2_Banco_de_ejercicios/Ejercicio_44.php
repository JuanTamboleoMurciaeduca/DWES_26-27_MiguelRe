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
        private string $nombre;

        public function __construct(string $nombre)
        {
            $this->renombrar($nombre);
        }

        public function nombre(): string
        {
            return $this->nombre;
        }

        public function renombrar(string $nombre): void
        {
            $nombre = trim($nombre);

            if ($nombre === '') {
                throw new InvalidArgumentException('El nombre de la categoría no puede estar vacío.');
            }

            $this->nombre = $nombre;
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

        public function ficha(): string
        {
            return $this->titulo . ' | ' . $this->autor->nombre . ' | ' . $this->categoria->nombre();
        }
    }

    $autor = new Autor('Frank Herbert', 'AUT-01');
    $categoria = new Categoria('Ciencia ficción');

    $dune = new Libro('Dune', $autor, $categoria);
    $mesias = new Libro('El mesías de Dune', $autor, $categoria);

    echo 'Antes de renombrar:<br>';
    echo $dune->ficha() . '<br>';
    echo $mesias->ficha() . '<br>';

    $categoria->renombrar('Narrativa');

    echo '<br>Después de renombrar:<br>';
    echo $dune->ficha() . '<br>';
    echo $mesias->ficha() . '<br>';
?>
