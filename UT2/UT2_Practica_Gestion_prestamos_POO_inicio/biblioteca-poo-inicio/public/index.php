<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Autor.php';
require_once __DIR__ . '/../src/Categoria.php';
require_once __DIR__ . '/../src/Libro.php';
require_once __DIR__ . '/../src/datos.php';

// Fase 4: convierte los registros de $datos en objetos Libro.
$libros = [];
foreach ($datos as $registro) {
    $autor = $registro['autor'] === null
        ? null : new Autor($registro['autor']);
    $categoria = new Categoria($registro['categoria']);
    $libros[] = new Libro(
        $registro['id'],
        $registro['titulo'],
        $registro['paginas'],
        $autor,
        $categoria,
        $registro['disponible'],
    );
}


// Fase 5: realiza aquí las comprobaciones de préstamos e identidad.
// Añade textos a $mensajes; la vista los mostrará debajo del catálogo.
// Termina devolviendo Dune para conservar el estado inicial del catálogo.
$mensajes = [];

// Fase 5.2
$dune = $libros[0];
$otro = $libros[2];
$mensajes[] = 'Dune al inicio: ' . ($dune->disponible ? 'true' : 'false');
$mensajes[] = '1984 al inicio: ' . ($otro->disponible ? 'true' : 'false');

$dune->prestar();
$mensajes[] = 'Dune después de prestar(): ' . ($dune->disponible ? 'true' : 'false');
$mensajes[] = '1984 después de prestar Dune: ' . ($otro->disponible ? 'true' : 'false');

$dune->devolver();
$mensajes[] = 'Dune después de devolver(): ' . ($dune->disponible ? 'true' : 'false');

$mensajes[] = 'Ficha de Dune: ' . $dune->ficha();
$mensajes[] = 'Ficha de Solaris: ' . $libros[3]->ficha();

// Fase 5.3
$alias = $dune;
$alias->prestar();
$mensajes[] = 'Dune después de prestar el alias: ' . ($dune->disponible ? 'true' : 'false');

$mensajes[] = 'El alias y Dune son el mismo objeto: ' . ($alias === $dune ? 'true' : 'false');

$copia = new Libro(10, 'Dune', 412, new Autor('Frank Herbert'), new Categoria('Ciencia ficción'));
$mensajes[] = 'La nueva instancia y Dune son el mismo objeto: ' . ($copia === $dune ? 'true' : 'false');

$dune->devolver();
$mensajes[] = 'Dune al terminar la simulación: ' . ($dune->disponible ? 'true' : 'false');

// Lectura del formulario facilitada. La búsqueda conserva el texto escrito.
$entrada = $_GET['q'] ?? '';
$entradaBusqueda = is_string($entrada) ? $entrada : '';
$soloDisponibles = isset($_GET['disponibles']);
$ordenEntrada = $_GET['orden'] ?? 'paginas';
$orden = is_string($ordenEntrada)
    && in_array($ordenEntrada, ['paginas', 'titulo'], true)
    ? $ordenEntrada : 'paginas';

// Fase 6.1: normaliza la búsqueda y filtra con array_filter.
$busqueda = '';
$visibles = $libros;

$busqueda = mb_strtolower(trim($entradaBusqueda), 'UTF-8');

$visibles = array_filter(
    $libros,
    fn (Libro $libro): bool =>
        str_contains(mb_strtolower($libro->titulo, 'UTF-8'), $busqueda)
        && (!$soloDisponibles || $libro->disponible)
);

// Fase 6.2: ordena $visibles mediante usort y <=>.
usort(
    $visibles,
    fn (Libro $a, Libro $b): int => $orden === 'paginas'
        ? $a->paginas <=> $b->paginas
        : $a->titulo <=> $b->titulo
);

// Fase 6.3: resumen del catálogo completo, antes de filtrar.
// Completa disponibles con array_filter y paginas con array_reduce.
$resumen = [
    'total' => count($libros),
    'disponibles' => count(array_filter($libros, fn (Libro $libro): bool => $libro->disponible)),
    'paginas' => array_reduce($libros, fn (int $suma, Libro $libro): int => $suma + $libro->paginas, 0),
];

// Fase 6.3: crea las fichas de los libros visibles con array_map.
$etiquetas = array_map(fn (Libro $libro): string => $libro->ficha(), $visibles);

// Fase 6.3: busca los ids 30 y 999 con array_find y añade mensajes.
$encontrado = array_find($libros, fn (Libro $libro): bool => $libro->id === 30);
$mensajes[] = 'Buscar id 30: ' . ($encontrado?->titulo ?? 'Libro no encontrado');

$noEncontrado = array_find($libros, fn (Libro $libro): bool => $libro->id === 999);
$mensajes[] = 'Buscar id 999: ' . ($noEncontrado?->titulo ?? 'Libro no encontrado');

require __DIR__ . '/../vista/catalogo.php';