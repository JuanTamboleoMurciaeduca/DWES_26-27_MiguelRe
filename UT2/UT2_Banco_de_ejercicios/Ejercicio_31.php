<?php
    declare(strict_types=1);

    final class Libro
    {
        public function __construct(
            public string $titulo,
            public bool $disponible = true,
        ) {
        }

        public function prestar(): void
        {
            $this->disponible = false;
        }

        public function devolver(): void
        {
            $this->disponible = true;
        }
    }

    function estado(Libro $libro): string
    {
        return $libro->titulo . ': ' . ($libro->disponible ? 'disponible' : 'prestado') . '<br>';
    }

    $dune = new Libro('Dune');
    $solaris = new Libro('Solaris');

    $dune->prestar();

    echo 'Tras prestar Dune:<br>';
    echo estado($dune);
    echo estado($solaris);

    $dune->devolver();

    echo '<br>Tras devolver Dune:<br>';
    echo estado($dune);
    echo estado($solaris);
?>
