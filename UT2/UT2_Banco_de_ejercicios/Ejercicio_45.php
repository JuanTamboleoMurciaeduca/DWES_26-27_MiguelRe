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

        public function cambiarEstado(EstadoEjemplar $estado): void
        {
            $this->estado = $estado;
        }
    }

    $e01 = new Ejemplar('E-01');
    $e02 = new Ejemplar('E-02', EstadoEjemplar::Prestado);
    $e03 = new Ejemplar('E-03', EstadoEjemplar::Perdido);

    $ejemplares = [$e01, $e02, $e03];

    echo 'Ejemplares:<br>';
    foreach ($ejemplares as $ejemplar) {
        echo $ejemplar->codigo() . ' | ' . $ejemplar->estado()->name . ' | ' . $ejemplar->estado()->value . '<br>';
    }

    $disponibles = array_filter(
        $ejemplares,
        fn (Ejemplar $ejemplar): bool => $ejemplar->estado() === EstadoEjemplar::Disponible
    );

    echo '<br>Disponibles:<br>';
    foreach ($disponibles as $ejemplar) {
        echo $ejemplar->codigo() . '<br>';
    }

    echo '<br>Cambios de estado de E-01:<br>';
    foreach (['prestado', 'perdido', 'reservado'] as $entrada) {
        $estado = EstadoEjemplar::tryFrom($entrada);

        if ($estado === null) {
            echo $entrada . ': Estado no válido<br>';
        } else {
            $e01->cambiarEstado($estado);
        }

        echo 'Estado actual de E-01: ' . $e01->estado()->value . '<br>';
    }

    echo '<br>Valores admitidos:<br>';
    foreach (EstadoEjemplar::cases() as $caso) {
        echo $caso->value . '<br>';
    }

    echo '<br>Recuento por estado:<br>';
    foreach (EstadoEjemplar::cases() as $caso) {
        $total = count(array_filter(
            $ejemplares,
            fn (Ejemplar $ejemplar): bool => $ejemplar->estado() === $caso
        ));

        echo $caso->value . ': ' . $total . '<br>';
    }
?>
