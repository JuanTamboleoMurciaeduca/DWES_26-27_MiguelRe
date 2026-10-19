<?php
    declare(strict_types=1);

    trait GeneraEtiqueta
    {
        public function etiqueta(): string
        {
            return $this->id() . ' · ' . $this->nombre();
        }
    }
?>