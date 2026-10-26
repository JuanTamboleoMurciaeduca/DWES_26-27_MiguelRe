<?php
    declare(strict_types=1);

    $cadena = "  Desarrollo    Web\t\tcon\n\n   PHP  ";

    echo 'Original: ';
    var_dump($cadena);
    echo '<br>';

    $normalizada = preg_replace('/\s+/', ' ', $cadena);

    echo 'Con preg_replace: ';
    var_dump($normalizada);
    echo '<br>';

    $limpia = trim($normalizada);

    echo 'Con trim después: ';
    var_dump($limpia);
?>