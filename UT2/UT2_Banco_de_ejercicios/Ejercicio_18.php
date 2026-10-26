<?php
    declare(strict_types=1);

    $cadena = ' DRÁCULA ';

    echo 'Original: ';
    var_dump($cadena);
    echo '<br>';

    $sinEspacios = trim($cadena);

    echo 'Tras trim: ';
    var_dump($sinEspacios);
    echo '<br>';

    $minusculas = mb_strtolower($sinEspacios, 'UTF-8');

    echo 'Tras mb_strtolower: ';
    var_dump($minusculas);
    echo '<br>';

    $longitud = mb_strlen($minusculas, 'UTF-8');

    echo 'Longitud con mb_strlen: ';
    var_dump($longitud);
    echo '<br>';

    echo 'Longitud con strlen: ';
    var_dump(strlen($minusculas));
?>