<?php
    declare(strict_types=1);

    $codigo = 'LIB-2026-0042';

    $prefijo = substr($codigo, 0, 3);
    $numero = substr($codigo, -4);

    echo 'Prefijo: ' . $prefijo . '<br>';
    echo 'Número: ' . $numero . '<br>';

    $titulo = 'Drácula';

    $conSubstr = substr($titulo, 0, 3);
    $conMbSubstr = mb_substr($titulo, 0, 3, 'UTF-8');

    echo '<br>';
    echo 'Con substr: ';
    var_dump($conSubstr);
    echo '<br>';
    echo 'Con mb_substr: ';
    var_dump($conMbSubstr);
?>