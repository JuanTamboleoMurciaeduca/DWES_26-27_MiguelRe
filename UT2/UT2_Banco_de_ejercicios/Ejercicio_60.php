<?php
    declare(strict_types=1);

    $datos = [
        ['titulo' => 'Dune', 'paginas' => 412, 'disponible' => true],
        ['titulo' => 'Solaris', 'paginas' => 216, 'disponible' => false],
        ['titulo' => 'Drácula', 'paginas' => 418, 'disponible' => true],
        ['titulo' => 'El Hobbit', 'paginas' => 310, 'disponible' => true],
    ];

    function titulosDisponiblesHasta(array $datos, int $maximo): array
    {
        if ($maximo < 1) {
            throw new InvalidArgumentException('El máximo debe ser al menos 1.');
        }

        $seleccionados = array_filter(
            $datos,
            fn (array $libro): bool => $libro['disponible'] && $libro['paginas'] <= $maximo
        );

        return array_values(array_map(
            fn (array $libro): string => $libro['titulo'],
            $seleccionados
        ));
    }

    final class Libro
    {
        public function __construct(
            private string $titulo,
            private int $paginas,
            private bool $disponible,
        ) {
        }

        public function titulo(): string
        {
            return $this->titulo;
        }

        public function paginas(): int
        {
            return $this->paginas;
        }

        public function estaDisponible(): bool
        {
            return $this->disponible;
        }
    }

    final class CatalogoService
    {
        public function __construct(private array $libros)
        {
        }

        public function titulosDisponiblesHasta(int $maximo): array
        {
            if ($maximo < 1) {
                throw new InvalidArgumentException('El máximo debe ser al menos 1.');
            }

            $seleccionados = array_filter(
                $this->libros,
                fn (Libro $libro): bool => $libro->estaDisponible() && $libro->paginas() <= $maximo
            );

            return array_values(array_map(
                fn (Libro $libro): string => $libro->titulo(),
                $seleccionados
            ));
        }
    }

    function formatear(array $titulos): string
    {
        return $titulos === [] ? 'lista vacía' : implode(', ', $titulos);
    }

    $libros = array_map(
        fn (array $registro): Libro => new Libro($registro['titulo'], $registro['paginas'], $registro['disponible']),
        $datos
    );

    $servicio = new CatalogoService($libros);

    foreach ([400, 500, 100] as $maximo) {
        $conFuncion = titulosDisponiblesHasta($datos, $maximo);
        $conObjetos = $servicio->titulosDisponiblesHasta($maximo);

        echo '<strong>Máximo ' . $maximo . '</strong><br>';
        echo 'Función: ' . formatear($conFuncion) . '<br>';
        echo 'Servicio: ' . formatear($conObjetos) . '<br>';
        echo 'Mismo resultado: ' . ($conFuncion === $conObjetos ? 'sí' : 'no') . '<br><br>';
    }

    echo '<strong>Máximo 0</strong><br>';

    try {
        titulosDisponiblesHasta($datos, 0);
    } catch (InvalidArgumentException $e) {
        echo 'Función rechazada: ' . $e->getMessage() . '<br>';
    }

    try {
        $servicio->titulosDisponiblesHasta(0);
    } catch (InvalidArgumentException $e) {
        echo 'Servicio rechazado: ' . $e->getMessage() . '<br>';
    }
?>
