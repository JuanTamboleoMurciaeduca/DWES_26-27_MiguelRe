<?php
    declare(strict_types=1);

    function normalizarId(int|string $id): int
    {
        return (int) $id;
    }

    function etiqueta(?string $titulo): string
    {
        return $titulo ?? 'Sin título';
    }

    var_dump(normalizarId(7));
    echo '<br>';
    var_dump(normalizarId('7'));
    echo '<br><br>';

    var_dump(etiqueta('Dune'));
    echo '<br>';
    var_dump(etiqueta(null));
?>