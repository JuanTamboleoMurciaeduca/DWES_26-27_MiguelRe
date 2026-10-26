<?php
    declare(strict_types=1);

    namespace App\Repository;

    use App\Contract\LibroRepository;
    use App\Model\Libro;

    final class ArrayLibroRepository implements LibroRepository
    {
        public function __construct(private array $libros)
        {
        }

        public function todos(): array
        {
            return $this->libros;
        }

        public function buscarPorId(int $id): ?Libro
        {
            return array_find(
                $this->libros,
                fn (Libro $libro): bool => $libro->id() === $id
            );
        }
    }
?>
