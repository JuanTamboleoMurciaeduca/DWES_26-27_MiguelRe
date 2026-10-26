<?php
    declare(strict_types=1);

    final class Libro
    {
        public string $titulo;
        public int $paginas = 0;
        public bool $disponible = true;
    }

    $libro = new Libro();

    $libro->titulo = 'Solaris';
    $libro->paginas = 216;

    echo 'Título: ' . $libro->titulo . '<br>';
    echo 'Páginas: ' . $libro->paginas . '<br>';
    echo 'Disponible: ' . ($libro->disponible ? 'sí' : 'no') . '<br>';
?>