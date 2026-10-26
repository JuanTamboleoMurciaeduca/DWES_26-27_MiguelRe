<?php
    declare(strict_types=1);

    enum EstadoEjemplar: string
    {
        case Disponible = 'disponible';
        case Prestado = 'prestado';
        case Perdido = 'perdido';
    }

    final class Ejemplar
    {
        public function __construct(
            private string $codigo,
            private EstadoEjemplar $estado = EstadoEjemplar::Disponible,
        ) {
        }

        public function codigo(): string
        {
            return $this->codigo;
        }

        public function estado(): EstadoEjemplar
        {
            return $this->estado;
        }

        public function prestar(): void
        {
            if ($this->estado !== EstadoEjemplar::Disponible) {
                throw new LogicException('No se puede prestar ' . $this->codigo . ' porque está ' . $this->estado->value . '.');
            }

            $this->estado = EstadoEjemplar::Prestado;
        }

        public function devolver(): void
        {
            if ($this->estado !== EstadoEjemplar::Prestado) {
                throw new LogicException('No se puede devolver ' . $this->codigo . ' porque está ' . $this->estado->value . '.');
            }

            $this->estado = EstadoEjemplar::Disponible;
        }

        public function marcarPerdido(): void
        {
            if ($this->estado === EstadoEjemplar::Perdido) {
                throw new LogicException('No se puede marcar como perdido ' . $this->codigo . ' porque ya está perdido.');
            }

            $this->estado = EstadoEjemplar::Perdido;
        }
    }

    function mostrar(Ejemplar $ejemplar): void
    {
        echo $ejemplar->codigo() . ': ' . $ejemplar->estado()->value . '<br>';
    }

    $e01 = new Ejemplar('E-01');

    $e01->prestar();
    mostrar($e01);

    $e01->devolver();
    mostrar($e01);

    $e01->prestar();
    mostrar($e01);

    $e01->marcarPerdido();
    mostrar($e01);

    echo '<br>';

    try {
        $e01->devolver();
    } catch (LogicException $e) {
        echo 'Rechazado: ' . $e->getMessage() . '<br>';
    }

    $e02 = new Ejemplar('E-02');

    try {
        $e02->devolver();
    } catch (LogicException $e) {
        echo 'Rechazado: ' . $e->getMessage() . '<br>';
    }

    echo '<br>Estados finales:<br>';
    mostrar($e01);
    mostrar($e02);
?>
