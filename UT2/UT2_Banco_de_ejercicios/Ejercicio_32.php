<?php
    declare(strict_types=1);

    final class Libro
    {
        public function __construct(
            public string $titulo,
            public int $paginas,
        ) {
        }

        public function ficha(): string
        {
            return $this->titulo . ' - ' . $this->paginas . ' páginas';
        }

        public function mostrarFicha(): void
        {
            echo $this->ficha();
        }
    }

    $dune = new Libro('Dune', 412);

    $ficha = $dune->ficha();

    echo 'Ficha: ' . $ficha . '<br>';

    $dune->mostrarFicha();
?>
