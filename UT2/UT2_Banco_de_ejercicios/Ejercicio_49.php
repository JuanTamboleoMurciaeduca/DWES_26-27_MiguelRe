<?php
    declare(strict_types=1);

    class LibroNoDisponibleException extends RuntimeException
    {
    }

    final class Libro
    {
        private string $titulo;
        private bool $disponible = true;

        public function __construct(string $titulo)
        {
            if (trim($titulo) === '') {
                throw new InvalidArgumentException('El título no puede estar vacío.');
            }

            $this->titulo = trim($titulo);
        }

        public function titulo(): string
        {
            return $this->titulo;
        }

        public function estaDisponible(): bool
        {
            return $this->disponible;
        }

        public function prestar(): void
        {
            if (!$this->disponible) {
                throw new LibroNoDisponibleException('El libro ' . $this->titulo . ' no está disponible.');
            }

            $this->disponible = false;
        }

        public function devolver(): void
        {
            $this->disponible = true;
        }
    }

    $dune = new Libro('Dune');

    try {
        $dune->prestar();
        echo 'Primer préstamo realizado<br>';
    } catch (LibroNoDisponibleException $e) {
        echo 'Error: ' . $e->getMessage() . '<br>';
    }

    try {
        $dune->prestar();
        echo 'Segundo préstamo realizado<br>';
    } catch (LibroNoDisponibleException $e) {
        echo 'Error: ' . $e->getMessage() . '<br>';
    }

    echo 'Disponible tras el rechazo: ' . ($dune->estaDisponible() ? 'true' : 'false') . '<br><br>';

    $dune->devolver();

    try {
        $dune->prestar();
        echo 'Dune devuelto y prestado de nuevo correctamente<br>';
    } catch (LibroNoDisponibleException $e) {
        echo 'Error: ' . $e->getMessage() . '<br>';
    }

    echo 'Disponible: ' . ($dune->estaDisponible() ? 'true' : 'false') . '<br><br>';

    try {
        $vacio = new Libro('   ');
    } catch (InvalidArgumentException $e) {
        echo 'Error al crear el libro: ' . $e->getMessage() . '<br>';
    }
?>
