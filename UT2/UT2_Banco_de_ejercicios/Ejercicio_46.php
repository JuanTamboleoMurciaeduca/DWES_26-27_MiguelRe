<?php
    declare(strict_types=1);

    final class Libro
    {
        public function __construct(
            private int $id,
            private string $titulo,
        ) {
        }

        public function id(): int
        {
            return $this->id;
        }

        public function titulo(): string
        {
            return $this->titulo;
        }
    }

    interface LibroRepository
    {
        public function todos(): array;
    }

    final class ArrayLibroRepository implements LibroRepository
    {
        public function __construct(private array $libros)
        {
        }

        public function todos(): array
        {
            return $this->libros;
        }
    }

    final class CatalogoDemostracionRepository implements LibroRepository
    {
        public function todos(): array
        {
            return [
                new Libro(10, 'Dune'),
                new Libro(20, 'Solaris'),
            ];
        }
    }

    function mostrarCatalogo(LibroRepository $repositorio): void
    {
        $libros = $repositorio->todos();

        if ($libros === []) {
            echo 'Catálogo vacío<br>';
        }

        foreach ($libros as $libro) {
            echo $libro->id() . ' | ' . $libro->titulo() . '<br>';
        }

        echo 'Total: ' . count($libros) . ' libros<br><br>';
    }

    mostrarCatalogo(new CatalogoDemostracionRepository());

    mostrarCatalogo(new ArrayLibroRepository([
        new Libro(30, 'Drácula'),
        new Libro(40, 'El Hobbit'),
    ]));

    mostrarCatalogo(new ArrayLibroRepository([]));
?>
