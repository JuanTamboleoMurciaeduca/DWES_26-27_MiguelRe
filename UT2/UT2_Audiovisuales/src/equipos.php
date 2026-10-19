<?php

declare(strict_types=1);

function limpiarEspacios(string $texto): string
{
    // TODO 1: limpiar extremos y agrupar espacios consecutivos.
    return preg_replace('/\s+/u', ' ', trim($texto));
}

function normalizarBusqueda(string $texto): string
{
    // REVISAR: ¿funciona con CÁMARA y ÓRBITA?
    return mb_strtolower(limpiarEspacios($texto), 'UTF-8');
}

function obtenerCategorias(array $equipos): array
{
    // TODO 2: extraer categorías sin duplicados en orden de aparición.
    return array_values(array_unique(array_column($equipos, 'categoria')));
}

function categoriaValida(string $categoria, array $categorias): bool
{
    return $categoria === '' || array_search($categoria, $categorias, true) !== false;
}

function unidadesPrestadas(array $prestamos, int $equipoId): int
{
    // TODO 5: sumar unidades de préstamos activos de este equipo.
    return array_reduce(
        array_filter(
            $prestamos,
            fn(array $p): bool => $p['equipoId'] === $equipoId && $p['estado'] === 'activo'
        ),
        fn(int $suma, array $p): int => $suma + $p['unidades'],
        0
    );
}

// Función facilitada: añade los cálculos a una copia de cada equipo.
function prepararEquipos(array $equipos, array $prestamos): array
{
    return array_map(
        function (array $equipo) use ($prestamos): array {
            $equipo['prestadas'] = unidadesPrestadas($prestamos, $equipo['id']);
            $equipo['disponibles'] = $equipo['unidades'] - $equipo['prestadas'];

            return $equipo;
        },
        $equipos
    );
}

function filtrarEquipos(
    array $equipos,
    string $texto,
    string $categoria,
    bool $soloDisponibles
): array
{
    // TODO 3: filtrar por nombre, categoría y unidades disponibles.
    $busqueda = normalizarBusqueda($texto);

    return array_filter(
        $equipos,
        fn(array $equipo): bool =>
            ($busqueda === '' || str_contains(normalizarBusqueda($equipo['nombre']), $busqueda))
            && ($categoria === '' || $equipo['categoria'] === $categoria)
            && (!$soloDisponibles || $equipo['disponibles'] > 0)
    );
}

function ordenarEquipos(array $equipos, string $orden): array
{
    // TODO 4: ordenar una copia según el criterio y desempatar por id.
    usort(
        $equipos,
        fn(array $a, array $b): int =>
        $orden === 'disponibles' ?
            (($a[$orden] <=> $b[$orden]) ?: $a['id'] <=> $b['id'])
            : ((normalizarBusqueda($a[$orden]) <=> normalizarBusqueda($b[$orden])) ?: $a['id'] <=> $b['id']),
    );

    return $equipos;
}

function resumirEquipos(array $equipos): array
{
    return [
        'cantidad' => count($equipos),
        'unidades' => array_reduce(
            $equipos,
            fn(int $s, array $a): int => $s + $a['unidades'],
            0
        ),
        'prestadas' => array_reduce(
            $equipos,
            fn(int $s, array $a): int => $s + $a['prestadas'],
            0
        ),
        'disponibles' => array_reduce(
            $equipos,
            fn(int $s, array $a): int => $s + $a['disponibles'],
            0
        ),
        'hayAgotados' => array_any(
            $equipos,
            fn(array $a): bool => $a['disponibles'] === 0
        ),
        'todosDisponibles' => array_all(
            $equipos,
            fn(array $a): bool => $a['disponibles'] > 0
        ),
    ];
}

// Función facilitada: permite pasar una función como dato.
function transformarNombres(array $nombres, callable $callback): array
{
    return array_map($callback, $nombres);
}

function generarEtiquetas(array $equipos, string $prefijo = 'Equipo: '): array
{
    // TODO 9: extraer nombres y usar una closure que capture el prefijo.
    $nombres = array_column($equipos, 'nombre');
    return transformarNombres(
        $nombres,
        function (string $nombre) use ($prefijo): string {
            return $prefijo . limpiarEspacios($nombre);
        }
    );
}

// Función facilitada. La entrada web valida el id antes de llamar.
function normalizarId(int|string $id): int
{
    return (int) $id;
}

function buscarPorId(array $equipos, int|string $id): ?array
{
    // TODO 10: buscar por id en todos los equipos; id no es índice.
    return array_find(
        $equipos,
        fn(array $equipo): bool => $equipo['id'] === normalizarId($id),
    );
}

function responsableVisible(?string $responsable): string
{
    // TODO 11: resolver el caso de responsable null.
    return $responsable ?? 'Responsable pendiente';
}

function inicioNombre(string $nombre): string
{
    return mb_substr(limpiarEspacios($nombre), 0, 3, 'UTF-8');
}

function codigoValido(string $codigo): bool
{
    return preg_match('/^AV-[0-9]{4}-[0-9]{4}$/D', $codigo) === 1;
}