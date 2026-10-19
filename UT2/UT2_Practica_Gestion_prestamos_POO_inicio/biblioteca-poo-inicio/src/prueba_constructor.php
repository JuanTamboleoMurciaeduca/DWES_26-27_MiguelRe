<?php
declare(strict_types=1);

require_once __DIR__ . '/Autor.php';
require_once __DIR__ . '/Categoria.php';
require_once __DIR__ . '/Libro.php';

// Fase 2.1: crea aquí un Autor y una Categoria y muestra sus nombres.
$autor = new Autor('Frank Herbert');
// echo $autor->nombre;

$categoria = new Categoria('Ciencia Ficción');
// echo $categoria->nombre;

// Fase 2.2: cuando completes Libro.php, añade su require_once arriba.
// Después crea los dos libros y muestra su disponibilidad.
// $libro = new Libro(10, 'Dune', 412, $autor, $categoria);
// echo $libro->disponible;

// $libro = new Libro(10, 'Dune', 412, $autor, $categoria, false);
// echo $libro->disponible;

// Fase 3.2: sustituye las pruebas anteriores por un Libro construido
// con las variables $titulo y $paginas. Muestra ambas propiedades.
$libro = new Libro(10, 'Dune', 412, $autor, $categoria, false);
echo $libro->titulo, $libro->paginas;

$libro = new Libro(10, ' Dune ', 412, $autor, $categoria, false);
echo $libro->titulo, $libro->paginas;

$libro = new Libro(10, '', 100, $autor, $categoria, false);
echo $libro->titulo, $libro->paginas;

$libro = new Libro(10, '   ', 100, $autor, $categoria, false);
echo $libro->titulo, $libro->paginas;

$libro = new Libro(10, 'Solaris', 0, $autor, $categoria, false);
echo $libro->titulo, $libro->paginas;

$libro = new Libro(10, 'Solaris', -5, $autor, $categoria, false);
echo $libro->titulo, $libro->paginas;

$libro = new Libro(10, '   ', 0, $autor, $categoria, false);
echo $libro->titulo, $libro->paginas;