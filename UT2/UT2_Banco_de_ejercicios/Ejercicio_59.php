<?php
    declare(strict_types=1);

    class OperacionBibliotecaException extends RuntimeException
    {
    }

    class LibroNoDisponibleException extends OperacionBibliotecaException
    {
    }

    final class Libro
    {
        public function __construct(
            private string $titulo,
            private bool $disponible = true,
        ) {
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
                throw new LibroNoDisponibleException('el libro ' . $this->titulo . ' ya está prestado');
            }

            $this->disponible = false;
        }
    }

    function prestarPorId(array $libros, int $id): void
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('el id debe ser positivo');
        }

        if (!isset($libros[$id])) {
            throw new OperacionBibliotecaException('no existe ningún libro con ese id');
        }

        $libros[$id]->prestar();
    }

    $libros = [
        10 => new Libro('Dune'),
        20 => new Libro('Solaris', false),
    ];

    foreach ([10, 10, 20, 99, 0] as $id) {
        try {
            prestarPorId($libros, $id);
            echo 'Id ' . $id . ': Préstamo realizado<br>';
        } catch (LibroNoDisponibleException $e) {
            echo 'Id ' . $id . ': libro no disponible, ' . $e->getMessage() . '<br>';
        } catch (OperacionBibliotecaException $e) {
            echo 'Id ' . $id . ': operación rechazada, ' . $e->getMessage() . '<br>';
        } catch (InvalidArgumentException $e) {
            echo 'Id ' . $id . ': id no válido, ' . $e->getMessage() . '<br>';
        } finally {
            echo 'Fin de operación ' . $id . '<br><br>';
        }
    }

    echo 'Disponibilidad final:<br>';
    foreach ($libros as $id => $libro) {
        echo $id . ' | ' . $libro->titulo() . ' | ' . ($libro->estaDisponible() ? 'disponible' : 'prestado') . '<br>';
    }
?>
