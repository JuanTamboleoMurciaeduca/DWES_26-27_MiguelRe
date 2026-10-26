<?php
    declare(strict_types=1);

    function sumarPaginas(int ...$paginas): int
    {
        return array_sum($paginas);
    }

    $paginas = [412, 1504, 328];

    $conUnpacking = sumarPaginas(...$paginas);
    $unoAUno = sumarPaginas(412, 1504, 328);

    echo 'Desempaquetando el array: ' . $conUnpacking . '<br>';
    echo 'Pasando los valores uno a uno: ' . $unoAUno . '<br>';
    echo $conUnpacking === $unoAUno ? 'Los resultados coinciden' : 'Los resultados no coinciden';
?>