<?php
    declare(strict_types=1);

    class JuegoMesa extends Juego
    {
        private int $jugadores;

        public function __construct(int $id, string $nombre, int $jugadores)
        {
            parent::__construct($id, $nombre);

            if ($jugadores <= 0) {
                throw new InvalidArgumentException('El número de jugadores debe ser mayor que cero.');
            }

            $this->jugadores = $jugadores;
        }

        public function jugadores(): int
        {
            return $this->jugadores;
        }

        public function plazoMaximo(): int
        {
            return 14;
        }

        public function ficha(): string
        {
            return parent::ficha() . ' · Jugadores: ' . $this->jugadores;
        }
    }
?>