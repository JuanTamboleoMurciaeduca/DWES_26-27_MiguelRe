<?php
    declare(strict_types=1);

    final class Autor
    {
        public function __construct(
            public readonly string $nombre,
            public readonly string $codigo,
        ) {
        }
    }

    $autor = new Autor('Frank Herbert', 'AUT-01');

    echo 'Autor creado: ' . $autor->nombre . '<br>';

    $autor->nombre = 'Otro autor';
?>
