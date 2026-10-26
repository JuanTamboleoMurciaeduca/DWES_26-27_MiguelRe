<?php
    declare(strict_types=1);

    $texto = 'Desarrollo Web con PHP';

    $casos = [
        [
            'caso' => 'Saber si aparece una palabra',
            'funcion' => 'str_contains',
            'motivo' => 'devuelve directamente true o false',
            'ejemplo' => var_export(str_contains($texto, 'Web'), true),
        ],
        [
            'caso' => 'Conocer su posición',
            'funcion' => 'strpos',
            'motivo' => 'devuelve la posición o false, y se comprueba con !== false',
            'ejemplo' => var_export(strpos($texto, 'Web'), true),
        ],
        [
            'caso' => 'Comprobar un prefijo',
            'funcion' => 'str_starts_with',
            'motivo' => 'solo mira el principio de la cadena',
            'ejemplo' => var_export(str_starts_with($texto, 'Desarrollo'), true),
        ],
        [
            'caso' => 'Comprobar un sufijo',
            'funcion' => 'str_ends_with',
            'motivo' => 'solo mira el final de la cadena',
            'ejemplo' => var_export(str_ends_with($texto, 'PHP'), true),
        ],
        [
            'caso' => 'Validar un formato con patrón',
            'funcion' => 'preg_match',
            'motivo' => 'permite describir el formato completo con una expresión regular',
            'ejemplo' => var_export(preg_match('/^LIB-\d{4}-\d{4}$/', 'LIB-2026-0042'), true),
        ],
        [
            'caso' => 'Sustituir espacios repetidos',
            'funcion' => 'preg_replace',
            'motivo' => 'con /\s+/ cambia cualquier grupo de espacios por uno solo',
            'ejemplo' => var_export(preg_replace('/\s+/', ' ', "Web   con\tPHP"), true),
        ],
        [
            'caso' => 'Trabajar con texto UTF-8',
            'funcion' => 'mb_strlen, mb_substr, mb_strtolower',
            'motivo' => 'cuentan caracteres y no bytes, así que respetan tildes y eñes',
            'ejemplo' => var_export(mb_strlen('Drácula', 'UTF-8'), true),
        ],
    ];

    foreach ($casos as $caso) {
        echo '<strong>' . $caso['caso'] . '</strong>: ' . $caso['funcion'] . ', porque ' . $caso['motivo'] . '. Ejemplo: ' . htmlspecialchars($caso['ejemplo']) . '<br>';
    }
?>