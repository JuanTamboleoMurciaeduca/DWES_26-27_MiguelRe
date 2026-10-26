<?php
    declare(strict_types=1);

    trait TieneFechaCreacion
    {
        private string $fechaCreacion;

        private function inicializarFechaCreacion(string $fecha): void
        {
            $this->fechaCreacion = $fecha;
        }

        public function fechaCreacion(): string
        {
            return $this->fechaCreacion;
        }

        public function etiquetaCreacion(): string
        {
            return 'Creado el ' . $this->fechaCreacion;
        }
    }

    final class Libro
    {
        use TieneFechaCreacion;

        public function __construct(private string $titulo, string $fecha)
        {
            $this->inicializarFechaCreacion($fecha);
        }

        public function titulo(): string
        {
            return $this->titulo;
        }
    }

    final class Socio
    {
        use TieneFechaCreacion;

        public function __construct(private string $nombre, string $fecha)
        {
            $this->inicializarFechaCreacion($fecha);
        }

        public function nombre(): string
        {
            return $this->nombre;
        }
    }

    $dune = new Libro('Dune', '2026-10-01');
    $solaris = new Libro('Solaris', '2026-10-02');
    $ana = new Socio('Ana', '2026-10-03');

    echo $dune->titulo() . ' | ' . $dune->fechaCreacion() . '<br>';
    echo $solaris->titulo() . ' | ' . $solaris->fechaCreacion() . '<br>';
    echo $ana->nombre() . ' | ' . $ana->fechaCreacion() . '<br>';

    echo '<br>';
    echo $dune->etiquetaCreacion() . '<br>';
    echo $solaris->etiquetaCreacion() . '<br>';
    echo $ana->etiquetaCreacion() . '<br>';
?>
