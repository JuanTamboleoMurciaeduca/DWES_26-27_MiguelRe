<?php
    declare(strict_types=1);

    function entrada(array $origen, string $clave, string $defecto = ''): string
    {
        // TODO F1. Lee solo cadenas y aplica el valor por defecto.
        if (isset($origen[$clave]) && is_string($origen[$clave])) {
            return $origen[$clave];
        }
        return $defecto;
    }

    function enteroPositivo(string $valor): int
    {
        // TODO F2. Valida antes de convertir; rechaza con InvalidArgumentException.
        $entero = filter_var($valor, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

        if ($entero === false) {
            throw new InvalidArgumentException("Indica un entero positivo.");
        }
        return $entero;
    }

    function limpiarEspacios(string $texto): string
    {
        return preg_replace('/\s+/u', ' ', trim($texto)) ?? '';
    }

    function normalizar(string $texto): string
    {
        return mb_strtolower(limpiarEspacios($texto), 'UTF-8');
    }

    function buscarPorId(array $actividades, int $id): ?Actividad
    {
        // TODO F3. Usa array_find con un callback tipado.
        return array_find(
            $actividades,
            fn(Actividad $actividad): bool => $actividad->id() === $id
        );
    }

    function filtrarActividades(
        array $actividades, string $texto, string $tipo,
        ?EstadoActividad $estado, bool $soloDisponibles
    ): array {
        // TODO F4. Combina las cuatro condiciones mediante array_filter.
        $textoNormalizado = normalizar($texto);

        $filtradas = array_filter(
            $actividades,
            function (Actividad $actividad) use ($textoNormalizado, $tipo, $estado, $soloDisponibles): bool {
                $cumpleTexto = $textoNormalizado === ''
                    || str_contains(normalizar($actividad->nombre()), $textoNormalizado);

                $cumpleTipo = $tipo === '' || $actividad->tipo() === $tipo;

                $cumpleEstado = $estado === null || $actividad->estado() === $estado;

                $cumpleDisponible = !$soloDisponibles
                    || ($actividad->estado() === EstadoActividad::Abierta && $actividad->plazasLibres() > 0);

                return $cumpleTexto && $cumpleTipo && $cumpleEstado && $cumpleDisponible;
            }
        );

        return array_values($filtradas);
    }

    function ordenarActividades(array $actividades, string $orden): array
    {
        // TODO F5. Ordena una copia con usort y desempata por id.
        $copia = $actividades;

        usort($copia, function (Actividad $a, Actividad $b) use ($orden): int {
            $comparacion = match ($orden) {
                'libres' => $a->plazasLibres() <=> $b->plazasLibres(),
                'nombre' => normalizar($a->nombre()) <=> normalizar($b->nombre()),
                default  => 0,
            };

            return $comparacion !== 0 ? $comparacion : $a->id() <=> $b->id();
        });

        return $copia;
    }

    function transformarActividades(array $actividades, callable $transformacion): array
    {
        return array_map($transformacion, $actividades);
    }

    function generarEtiquetas(
        array $actividades, string $prefijo = 'Actividad: '
    ): array
    {
        // TODO F6. Usa transformarActividades y una closure con use.
        return transformarActividades(
            $actividades,
            function (Actividad $actividad) use ($prefijo): string {
                return $actividad->etiqueta($prefijo);
            }
        );
    }

    function resumirActividades(array $actividades): array
    {
        // TODO F7. Calcula las cinco magnitudes con array_reduce.
        $inicial = [
            'cantidad'  => 0,
            'capacidad' => 0,
            'ocupadas'  => 0,
            'libres'    => 0,
            'importe'   => 0,
        ];

        return array_reduce(
            $actividades,
            function (array $resumen, Actividad $actividad): array {
                $resumen['cantidad']++;
                $resumen['capacidad'] += $actividad->capacidad();
                $resumen['ocupadas']  += $actividad->ocupadas();
                $resumen['libres']    += $actividad->plazasLibres();
                $resumen['importe']   += $actividad->importe($actividad->ocupadas());
                return $resumen;
            },
            $inicial
        );
    }

    function e(string $texto): string
    {
        return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    function euros(int $centimos): string
    {
        return number_format($centimos / 100, 2, ',', '.') . ' €';
    }
?>