<?php
    declare(strict_types=1);

    namespace App\Model;

    final class Libro
    {
        public function __construct(private string $titulo)
        {
        }

        public function titulo(): string
        {
            return $this->titulo;
        }
    }
?>
