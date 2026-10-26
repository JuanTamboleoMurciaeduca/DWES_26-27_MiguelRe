<?php
    declare(strict_types=1);

    $catalogo = [
        ['titulo' => 'Dune', 'paginas' => 412, 'disponible' => true],
        ['titulo' => 'Drácula', 'paginas' => 418, 'disponible' => false],
        ['titulo' => '1984', 'paginas' => 328, 'disponible' => true],
        ['titulo' => 'It', 'paginas' => 1504, 'disponible' => false],
    ];

    $disponibles = array_filter(
        $catalogo, 
        fn (array $libro): bool => $libro['disponible'] === true
    );

    foreach ($disponibles as $clave => $libro) {
        echo "Titulo: " . $libro['titulo'] . "  |  " . "Disponible: " . ($libro['disponible'] ? 'si' : 'no') . "<br><br>";
    }
?>