<?php
    declare(strict_types=1);

    namespace App\Servicio;

    use App\Contrato\RepositorioEnvios;
    use App\Excepcion\EnvioException;
    use App\Modelo\Envio;
    use App\Modelo\EstadoEnvio;
    use InvalidArgumentException;

    class ServicioEnvios
    {
        private RepositorioEnvios $repositorio;

        public function __construct(RepositorioEnvios $repositorio)
        {
            $this->repositorio = $repositorio;
        }

        public function enviar(int $id): void
        {
            $this->obtener($id)->enviar();
        }

        public function entregar(int $id): void
        {
            $this->obtener($id)->entregar();
        }

        public function cancelar(int $id): void
        {
            $this->obtener($id)->cancelar();
        }

        private function obtener(int $id): Envio
        {
            $envio = $this->repositorio->buscar($id);

            if ($envio === null) {
                throw new EnvioException("No existe ningún envío con id $id.");
            }

            return $envio;
        }

        public function consultar(
            string $texto = '',
            ?string $modalidad = null,
            ?EstadoEnvio $estado = null,
            string $orden = 'precio'
        ): array {
            if ($modalidad !== null && $modalidad !== 'normal' && $modalidad !== 'urgente') {
                throw new InvalidArgumentException("Modalidad desconocida: $modalidad.");
            }
            if ($orden !== 'precio' && $orden !== 'peso') {
                throw new InvalidArgumentException("Orden desconocido: $orden.");
            }

            $buscado = self::normalizar($texto);

            $resultado = array_filter(
                $this->repositorio->todos(),
                function (Envio $envio) use ($buscado, $modalidad, $estado): bool {
                    $cumpleTexto = $buscado === ''
                        || str_contains(self::normalizar($envio->cliente()), $buscado);
                    $cumpleModalidad = $modalidad === null || $envio->modalidad() === $modalidad;
                    $cumpleEstado = $estado === null || $envio->estado() === $estado;

                    return $cumpleTexto && $cumpleModalidad && $cumpleEstado;
                }
            );

            usort($resultado, function (Envio $a, Envio $b) use ($orden): int {
                $valorA = $orden === 'precio' ? $a->tarifa() : $a->peso();
                $valorB = $orden === 'precio' ? $b->tarifa() : $b->peso();

                return [$valorA, $a->id()] <=> [$valorB, $b->id()];
            });

            return $resultado;
        }

        private static function normalizar(string $texto): string
        {
            $texto = trim($texto);
            $texto = preg_replace('/\s+/u', ' ', $texto);
            return mb_strtolower($texto, 'UTF-8');
        }

        public function etiquetas(array $envios): array
        {
            return array_map(
                function (Envio $envio): string {
                    return sprintf(
                        '%d | %s | %s | %s | %d céntimos.',
                        $envio->id(),
                        $envio->cliente(),
                        $envio->modalidad(),
                        $envio->estado()->value,
                        $envio->tarifa()
                    );
                },
                $envios
            );
        }

        public function resumir(array $envios): array
        {
            $inicial = [
                'cantidad' => 0,
                'peso' => 0,
                'importeTotal' => 0,
                'importeActivo' => 0,
                'pendiente' => 0,
                'enviado' => 0,
                'entregado' => 0,
                'cancelado' => 0,
            ];

            return array_reduce(
                $envios,
                function (array $acumulado, Envio $envio): array {
                    $acumulado['cantidad']++;
                    $acumulado['peso'] += $envio->peso();
                    $acumulado['importeTotal'] += $envio->tarifa();

                    if ($envio->estado() !== EstadoEnvio::Cancelado) {
                        $acumulado['importeActivo'] += $envio->tarifa();
                    }

                    $acumulado[$envio->estado()->value]++;

                    return $acumulado;
                },
                $inicial
            );
        }
    }
?>