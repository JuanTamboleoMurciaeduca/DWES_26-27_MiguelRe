<?php
    declare(strict_types=1);

    namespace App\Service;

    use App\Model\Libro;

    final class CatalogoService
    {
        public function __construct(private array $libros)
        {
        }

        public function fichas(): array
        {
            return array_map(
                fn (Libro $libro): string => $libro->ficha(),
                $this->libros
            );
        }
    }
?>
