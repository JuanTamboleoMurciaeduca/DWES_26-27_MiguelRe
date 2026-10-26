<?php
    declare(strict_types=1);

    abstract class RecursoBiblioteca
    {
        public function __construct(protected string $titulo)
        {
        }

        abstract public function tipo(): string;

        final public function origen(): string
        {
            return 'Biblioteca';
        }
    }

    final class Folleto extends RecursoBiblioteca
    {
        public function tipo(): string
        {
            return 'folleto';
        }

        public function origen(): string
        {
            return 'Otro origen';
        }
    }

    echo 'Esta línea no llega a mostrarse';
?>
