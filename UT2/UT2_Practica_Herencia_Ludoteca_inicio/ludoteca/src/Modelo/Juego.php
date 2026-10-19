<?php
    declare(strict_types=1);

    abstract class Juego implements Prestable
    {
        use GeneraEtiqueta;

        private int $id;
        private string $nombre;
        private bool $prestado = false;
        private int $dias = 0;

        public function __construct(int $id, string $nombre)
        {
            $nombre = trim($nombre);

            if ($id <= 0) {
                throw new InvalidArgumentException('El id debe ser mayor que cero.');
            }

            if ($nombre === '') {
                throw new InvalidArgumentException('El nombre no puede estar vacío.');
            }

            $this->id = $id;
            $this->nombre = $nombre;
        }

        public function id(): int
        {
            return $this->id;
        }

        public function nombre(): string
        {
            return $this->nombre;
        }

        public function prestado(): bool
        {
            return $this->prestado;
        }

        public function dias(): int
        {
            return $this->dias;
        }

        abstract public function plazoMaximo(): int;

        public function ficha(): string
        {
            $estado = $this->prestado ? 'Prestado' : 'Disponible';

            return $this->etiqueta() . ' · ' . $estado . ' · Días: ' . $this->dias;
        }

        public function prestar(int $dias): void
        {
            if ($dias <= 0) {
                throw new InvalidArgumentException('Los días del préstamo deben ser positivos.');
            }

            if ($this->prestado) {
                throw new PrestamoException($this->etiqueta() . ' ya está prestado.');
            }

            if ($dias > $this->plazoMaximo()) {
                throw new PrestamoException(
                    $this->etiqueta() . ': ' . $dias . ' días superan el plazo máximo de '
                    . $this->plazoMaximo() . '.'
                );
            }

            $this->prestado = true;
            $this->dias = $dias;
        }

        public function renovar(int $diasExtra): void
        {
            if ($diasExtra <= 0) {
                throw new InvalidArgumentException('Los días de renovación deben ser positivos.');
            }

            if (!$this->prestado) {
                throw new PrestamoException($this->etiqueta() . ' no está prestado y no se puede renovar.');
            }

            if ($this->dias + $diasExtra > $this->plazoMaximo()) {
                throw new PrestamoException(
                    $this->etiqueta() . ': la renovación superaría el plazo máximo de '
                    . $this->plazoMaximo() . ' días.'
                );
            }

            $this->dias += $diasExtra;
        }

        public function devolver(): void
        {
            if (!$this->prestado) {
                throw new PrestamoException($this->etiqueta() . ' no está prestado y no se puede devolver.');
            }

            $this->prestado = false;
            $this->dias = 0;
        }
    }
?>