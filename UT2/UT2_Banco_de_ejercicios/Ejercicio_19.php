<?php
    declare(strict_types=1);

    function mostrarResultado(string $codigo, int|false $resultado): void
    {
        $mensaje = match ($resultado) {
            1 => 'válido',
            0 => 'no válido',
            false => 'error en el patrón',
        };

        echo $codigo . ': ';
        var_dump($resultado);
        echo ' (' . $mensaje . ')<br>';
    }

    $patron = '/^LIB-\d{4}-\d{4}$/';

    $codigos = ['LIB-2026-0042', 'LIB-26-0042', 'lib-2026-0042'];

    foreach ($codigos as $codigo) {
        mostrarResultado($codigo, preg_match($patron, $codigo));
    }

    $resultadoError = @preg_match('/^LIB-(\d{4}-\d{4}$/', 'LIB-2026-0042');
    mostrarResultado('Patrón mal escrito', $resultadoError);
?>