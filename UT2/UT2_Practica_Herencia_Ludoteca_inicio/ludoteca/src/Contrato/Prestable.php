<?php
    declare(strict_types=1);

    interface Prestable
    {
        public function prestar(int $dias): void;

        public function renovar(int $diasExtra): void;

        public function devolver(): void;
    }
?>