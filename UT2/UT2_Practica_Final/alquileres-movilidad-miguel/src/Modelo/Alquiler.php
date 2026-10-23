<?php
    declare(strict_types=1);

    namespace Clase\Alquileres\Modelo;

    use Clase\Alquileres\Exception\AlquilerException;
    use InvalidArgumentException;

    abstract class Alquiler {
        private readonly int $id;
        private string $cliente;
        private int $dias;
        private EstadoAlquiler $estado;

        public function id(): int {
            return $this->id;
        }

        public function cliente(): string {
            return $this->cliente;
        }
        
        public function dias(): int {
            return $this->dias;
        }

        public function estado(): EstadoAlquiler {
            return $this->estado;
        }

        public function __construct(int $id, string $cliente, int $dias, EstadoAlquiler $estado) {
            $cliente = trim($cliente);
            
            if ($id <= 0) {
                throw new InvalidArgumentException('El id tiene que ser un número positivo.');
            }

            if ($cliente === '') {
                throw new InvalidArgumentException('El nombre no puede estar vacío.');
            }

            if ($dias < 1 || $dias > 7) {
                throw new InvalidArgumentException('La duración está fuera del rango permitido.');
            }

            $this->id = $id;
            $this->cliente = $cliente;
            $this->dias = $dias;
            $this->estado = $estado;
        }

        public abstract function modalidad(): string;

        protected abstract function tarifaDiaria(): int;

        public function importe(): int {
            return $this->dias * $this->tarifaDiaria();
        }

        public function iniciar(): void {
            if ($this->estado !== EstadoAlquiler::Reservado) {
                throw new AlquilerException('El cambio no se ha realizado ya que el valor de estado no es reservado.');
            } elseif ($this->estado === EstadoAlquiler::Reservado) {
                $this->estado = EstadoAlquiler::Activo;
            }
        }

        public function finalizar(): void {
            if ($this->estado !== EstadoAlquiler::Activo) {
                throw new AlquilerException('El cambio no se ha realizado ya que el valor de estado no es activo.');
            } elseif ($this->estado === EstadoAlquiler::Activo) {
                $this->estado = EstadoAlquiler::Finalizado;
            }
        }

    }
?>