<?php
    declare(strict_types=1);

    namespace App\Service;

    use App\Contract\LibroRepository;
    use App\Model\Libro;

    final class CatalogoService
    {
        public function __construct(private LibroRepository $repositorio)
        {
        }

        public function disponibles(): array
        {
            return array_filter(
                $this->repositorio->todos(),
                fn (Libro $libro): bool => $libro->estaDisponible()
            );
        }

        public function titulosDisponibles(): array
        {
            return array_map(
                fn (Libro $libro): string => $libro->titulo(),
                $this->disponibles()
            );
        }
    }
?>
