<?php
    declare(strict_types=1);

    final class Libro
    {
        private int $id;
        private string $titulo;
        private int $paginas;
        private bool $disponible;

        public function __construct(int $id, string $titulo, int $paginas)
        {
            $titulo = trim($titulo);

            if ($id <= 0) {
                throw new InvalidArgumentException('El id debe ser mayor que cero.');
            }

            if ($titulo === '') {
                throw new InvalidArgumentException('El título no puede estar vacío.');
            }

            if ($paginas <= 0) {
                throw new InvalidArgumentException('El número de páginas debe ser mayor que cero.');
            }

            $this->id = $id;
            $this->titulo = $titulo;
            $this->paginas = $paginas;
            $this->disponible = true;
        }

        public function id(): int
        {
            return $this->id;
        }

        public function titulo(): string
        {
            return $this->titulo;
        }

        public function paginas(): int
        {
            return $this->paginas;
        }

        public function estaDisponible(): bool
        {
            return $this->disponible;
        }

        public function prestar(): void
        {
            if (!$this->disponible) {
                throw new LogicException('El libro ' . $this->titulo . ' ya está prestado.');
            }

            $this->disponible = false;
        }

        public function devolver(): void
        {
            $this->disponible = true;
        }
    }

    function ficha(Libro $libro): string
    {
        return $libro->id() . ' | ' . $libro->titulo() . ' | ' . $libro->paginas() . ' páginas | '
            . ($libro->estaDisponible() ? 'disponible' : 'prestado') . '<br>';
    }

    $dune = new Libro(10, 'Dune', 412);
    $solaris = new Libro(20, 'Solaris', 216);

    echo 'Inicio:<br>';
    echo ficha($dune);
    echo ficha($solaris);

    $dune->prestar();

    echo '<br>Tras prestar Dune:<br>';
    echo ficha($dune);
    echo ficha($solaris);

    $dune->devolver();

    echo '<br>Tras devolver Dune:<br>';
    echo ficha($dune);
    echo ficha($solaris);

    echo '<br>Doble préstamo:<br>';

    try {
        $dune->prestar();
        $dune->prestar();
    } catch (LogicException $e) {
        echo 'Error: ' . $e->getMessage() . '<br>';
    }

    echo ficha($dune);

    echo '<br>Construcción con 0 páginas:<br>';

    try {
        $libroInvalido = new Libro(30, 'Drácula', 0);
    } catch (InvalidArgumentException $e) {
        echo 'Rechazado: ' . $e->getMessage() . '<br>';
    }
?>
