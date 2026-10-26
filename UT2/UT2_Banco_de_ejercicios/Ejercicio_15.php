<?php
    declare(strict_types=1);

    $catalogo = [
        10 => ['titulo' => 'Solaris', 'autor' => 'Stanislaw Lem'],
        20 => ['titulo' => 'Dune', 'autor' => 'Frank Herbert'],
        30 => ['titulo' => 'Metamorfosis', 'autor' => 'Franz Kafka'],
    ];

    $copia = $catalogo;

    uasort($catalogo, fn (array $a, array $b): int => $a['titulo'] <=> $b['titulo']);

    echo 'Con uasort:<br>';
    foreach ($catalogo as $id => $libro) {
        echo $id . ': ' . $libro['titulo'] . '<br>';
    }

    usort($copia, fn (array $a, array $b): int => $a['titulo'] <=> $b['titulo']);

    echo '<br>Con usort:<br>';
    foreach ($copia as $id => $libro) {
        echo $id . ': ' . $libro['titulo'] . '<br>';
    }
?>