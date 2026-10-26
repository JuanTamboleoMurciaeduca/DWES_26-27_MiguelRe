<?php
    declare(strict_types=1);

    $libro = [
        'titulo' => 'Dune',
        'autor' => 'Frank Herbert',
    ];

    ['titulo' => $t, 'autor' => $a] = $libro;

    echo $t . ' / ' . $a;
?>