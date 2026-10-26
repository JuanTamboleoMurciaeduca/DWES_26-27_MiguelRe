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

    echo 'Intentando instanciar RecursoBiblioteca...<br>';

    $recurso = new RecursoBiblioteca('Recurso imposible');
?>
