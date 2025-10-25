<?php
class Cliente {
    private static int $contador = 1;


    public string $nombre;
    private int $numero;
    private int $maxAlquilerConcurrente;
    private int $numSoportesAlquilados = 0;
    private array $soportesAlquilados = [];

    public function __construct(string $nombre, int $maxAlquilerConcurrente=3){
        $this->nombre = $nombre;
        $this->numero = self::$contador++;
        $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
    }

    public function getNumero(): int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): void
    {
        $this->numero = $numero;
    }

    public function getNumSoportesAlquilados(): int
    {
        return $this->numSoportesAlquilados;
    }

    public function muestraResumen(): void{
        echo "$this->nombre con " . count($this->soportesAlquilados) . " soportes alquilados";
    }

    public function tieneAlquilado(Soporte $s): bool{
        return in_array($s, $this->soportesAlquilados);
    }

    public function alquilar(Soporte $s): bool{
        if ($this->tieneAlquilado($s)) {
            echo "<br>El soporte ya está alquilado por este cliente.<br>";
            return false;
        }
        if ($this->numSoportesAlquilados >= $this->maxAlquilerConcurrente) {
            echo "<br>No se pudo alquilar: se alcanzó el máximo de alquileres concurrentes.";
            return false;
        }

        $this->soportesAlquilados[] = $s;
        $this->numSoportesAlquilados++;
        echo "<br><strong>Alquilado soporte a:</strong> $this->nombre";
        $s->muestraResumen();
        return true;
    }

    public function devolver(int $numSoporte): bool {
        $soporteEncontrado = null;
        foreach ($this->soportesAlquilados as $soporte) {
            if ($soporte->getNumero() === $numSoporte) {
                $soporteEncontrado = $soporte;
                break;
            }
        }

        if ($soporteEncontrado && $this->tieneAlquilado($soporteEncontrado)) {
            $this->soportesAlquilados = array_filter($this->soportesAlquilados, fn($s) => $s->getNumero() !== $numSoporte);

            $this->numSoportesAlquilados--;
            echo "<br>Soporte número $numSoporte devuelto correctamente.";
            return true;
        }

        echo "<br>No se encontró ningún soporte con número $numSoporte alquilado por este cliente.";
        return false;
    }

    public function listaAlquileres(): void{
        echo "<br><strong>El cliente tiene $this->numSoportesAlquilados soportes alquilados</strong>";
        if($this->numSoportesAlquilados > 0){
            foreach ($this->soportesAlquilados as $soporte){
                $soporte->muestraResumen();
            }
        }
    }

}