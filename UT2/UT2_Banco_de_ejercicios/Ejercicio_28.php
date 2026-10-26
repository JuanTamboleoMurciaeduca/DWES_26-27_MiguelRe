<?php
    declare(strict_types=1);

    $datos = [
        'titulo' => 'Dune',
        'autor' => 'Frank Herbert',
        'paginas' => 412,
        'disponible' => true,
    ];

    class Libro
    {
        public string $titulo;
        public string $autor;
        public int $paginas;
        public bool $disponible;

        public function __construct(string $titulo, string $autor, int $paginas, bool $disponible)
        {
            $this->titulo = $titulo;
            $this->autor = $autor;
            $this->paginas = $paginas;
            $this->disponible = $disponible;
        }
    }

    $libro = new Libro($datos['titulo'], $datos['autor'], $datos['paginas'], $datos['disponible']);

    echo 'Título: ' . $libro->titulo . '<br>';
    echo 'Autor: ' . $libro->autor . '<br>';
    echo 'Páginas: ' . $libro->paginas . '<br>';
    echo 'Disponible: ' . ($libro->disponible ? 'sí' : 'no') . '<br>';
?>