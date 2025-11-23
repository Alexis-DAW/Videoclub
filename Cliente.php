<?php
namespace DWES\Videoclub;
include_once("Util\SoporteYaAlquiladoException.php");
include_once ("Util\CupoSuperadoException.php");
include_once ("Util\SoporteNoEncontradoException.php");

use DWES\Videoclub\Util\CupoSuperadoException;
use DWES\Videoclub\Util\SoporteYaAlquiladoException;
use DWES\Videoclub\Util\SoporteNoEncontradoException;
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

    public function getNumero(): int{
        return $this->numero;
    }

    public function setNumero(int $numero): void{
        $this->numero = $numero;
    }

    public function getNumSoportesAlquilados(): int{
        return $this->numSoportesAlquilados;
    }

    public function getMaxAlquilerConcurrente(): int{
        return $this->maxAlquilerConcurrente;
    }


    public function muestraResumen(): void{
        echo "$this->nombre con " . count($this->soportesAlquilados) . " soportes alquilados";
    }

    public function tieneAlquilado(Soporte $s): bool{
        return in_array($s, $this->soportesAlquilados);
    }

    public function alquilar(Soporte $s): Cliente{
        if ($this->tieneAlquilado($s)) {
            throw new SoporteYaAlquiladoException("El soporte $s->titulo ya está alquilado por $this->nombre");
        }
        if ($this->numSoportesAlquilados >= $this->maxAlquilerConcurrente) {
            throw new CupoSuperadoException("$this->nombre no puede alquilar más, cupo de $this->maxAlquilerConcurrente superado.");
        }

        $this->soportesAlquilados[] = $s;
        $this->numSoportesAlquilados++;

        $s->alquilado = true;

//        echo "<p><strong>Alquilado soporte a:</strong> $this->nombre</p>";
//        $s->muestraResumen();
        return $this;
    }

    public function devolver(int $numSoporte): Cliente {
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
            return $this;
        }

        throw new SoporteNoEncontradoException("No se encontró ningún soporte con número $numSoporte alquilado 
        por el cliente $this->nombre.");
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