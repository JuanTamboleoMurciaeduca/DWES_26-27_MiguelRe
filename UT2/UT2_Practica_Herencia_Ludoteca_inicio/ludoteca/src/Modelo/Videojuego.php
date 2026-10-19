<?php
    declare(strict_types=1);

    class Videojuego extends Juego
    {
        private string $plataforma;

        public function __construct(int $id, string $nombre, string $plataforma)
        {
            parent::__construct($id, $nombre);

            $plataforma = trim($plataforma);

            if ($plataforma === '') {
                throw new InvalidArgumentException('La plataforma no puede estar vacía.');
            }

            $this->plataforma = $plataforma;
        }

        public function plataforma(): string
        {
            return $this->plataforma;
        }

        public function plazoMaximo(): int
        {
            return 7;
        }

        public function ficha(): string
        {
            return parent::ficha() . ' · Plataforma: ' . $this->plataforma;
        }
    }
?>