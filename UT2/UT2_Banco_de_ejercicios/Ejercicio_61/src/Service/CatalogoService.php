<?php
    declare(strict_types=1);

    namespace App\Service;

    use App\Contract\LibroRepository;
    use App\Model\Libro;
    use InvalidArgumentException;

    final class CatalogoService
    {
        public function __construct(private LibroRepository $repositorio)
        {
        }

        public function buscarDisponibles(string $texto, int $maximo): array
        {
            if ($maximo < 1) {
                throw new InvalidArgumentException('El máximo de páginas debe ser al menos 1.');
            }

            $busqueda = mb_strtolower(trim($texto), 'UTF-8');

            $resultado = array_filter(
                $this->repositorio->todos(),
                fn (Libro $libro): bool => $libro->estaDisponible()
                    && str_contains(mb_strtolower($libro->titulo(), 'UTF-8'), $busqueda)
                    && $libro->paginas() <= $maximo
            );

            usort($resultado, fn (Libro $a, Libro $b): int => $a->paginas() <=> $b->paginas());

            return $resultado;
        }

        public function prestarPorId(int $id): void
        {
            $this->buscar($id)->prestar();
        }

        public function devolverPorId(int $id): void
        {
            $this->buscar($id)->devolver();
        }

        private function buscar(int $id): Libro
        {
            $libro = $this->repositorio->buscarPorId($id);

            if ($libro === null) {
                throw new InvalidArgumentException('No existe ningún libro con id ' . $id . '.');
            }

            return $libro;
        }
    }
?>
