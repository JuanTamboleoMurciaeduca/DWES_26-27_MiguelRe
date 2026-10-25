<?php
    declare(strict_types=1);

    // TODO M4. Implementa Responsable final, sus propiedades readonly y el trait.
    final class Responsable
    {
        use GeneraEtiqueta;

        public function __construct(
            public readonly int $id,
            public readonly string $nombre
        ) {
            if ($id <= 0) {
                throw new InvalidArgumentException('El id tiene que ser mayor a 0.');
            }
            if (trim($nombre) === '') {
                throw new InvalidArgumentException('El nombre no puede estar vacío.');
            }
        }

        public function id(): int
        {
            return $this->id;
        }

        public function nombre(): string
        {
            return $this->nombre;
        }
    }
?>