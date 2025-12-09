<?php
namespace DWES\Videoclub;

include_once __DIR__ . "/Util/VideoclubException.php";
include_once __DIR__ . "/Util/SoporteNoEncontradoException.php";
include_once __DIR__ . "/Util/SoporteYaAlquiladoException.php";
include_once __DIR__ . "/Util/CupoSuperadoException.php";

use DWES\Videoclub\Util\CupoSuperadoException;
use DWES\Videoclub\Util\SoporteYaAlquiladoException;
use DWES\Videoclub\Util\SoporteNoEncontradoException;

class Cliente {
    public string $nombre;
    private int $numero;
    private array $soportesAlquilados;
    private int $numSoportesAlquilados;
    private int $maxAlquilerConcurrente;
    public string $user;
    public string $password;

    public function __construct(string $nombre, int $maxAlquilerConcurrente = 3, string $user = "", string $password = "", int $numero = 0) {
        $this->nombre = $nombre;
        $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
        $this->user = $user;
        $this->password = $password;

        // todo: Si no se pasa número (o es 0), se podría generar uno aleatorio
        $this->numero = $numero;

        $this->soportesAlquilados = [];
        $this->numSoportesAlquilados = 0;
    }

    public function getNumero(): int {
        return $this->numero;
    }

    public function getNumSoportesAlquilados(): int {
        return $this->numSoportesAlquilados;
    }

    public function getMaxAlquilerConcurrente(): int {
        return $this->maxAlquilerConcurrente;
    }

    public function getAlquileres(): array {
        return $this->soportesAlquilados;
    }

    public function getSoportesAlquilados(): array {
        return $this->getAlquileres();
    }

    public function getUser(): string {
        return $this->user;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setNombre(string $nombre): void { $this->nombre = $nombre; }
    public function setUser(string $user): void { $this->user = $user; }
    public function setPassword(string $password): void { $this->password = $password; }

    public function muestraResumen() {
        echo "Nombre: " . $this->nombre . " (Usuario: " . $this->user . ") | Cantidad Alquileres: " . count($this->soportesAlquilados);
    }

    public function tieneAlquilado(Soporte $s): bool {
        foreach ($this->soportesAlquilados as $soporte) {
            if ($soporte->getNumero() === $s->getNumero()) {
                return true;
            }
        }
        return false;
    }

    public function alquilar(Soporte $s): Cliente {
        if ($this->tieneAlquilado($s)) {
            throw new SoporteYaAlquiladoException("El cliente ya tiene alquilado el soporte " . $s->titulo);
        }
        if ($this->numSoportesAlquilados >= $this->maxAlquilerConcurrente) {
            throw new CupoSuperadoException("Cupo de alquileres superado.");
        }
        if ($s->alquilado) {
            throw new SoporteYaAlquiladoException("El soporte ya está alquilado por otro socio.");
        }

        $this->soportesAlquilados[] = $s;
        $this->numSoportesAlquilados++;
        $s->alquilado = true;

        echo "<p>✅ Alquiler realizado: <strong>" . $s->titulo . "</strong> a " . $this->nombre . "</p>";

        return $this;
    }

    public function devolver(int $numSoporte): Cliente {
        foreach ($this->soportesAlquilados as $key => $soporte) {
            if ($soporte->getNumero() === $numSoporte) {
                $soporte->alquilado = false;
                unset($this->soportesAlquilados[$key]);
                $this->numSoportesAlquilados--;

                $this->soportesAlquilados = array_values($this->soportesAlquilados);
                echo "<p>Soporte devuelto correctamente.</p>";
                return $this;
            }
        }
        throw new SoporteNoEncontradoException("El soporte no estaba alquilado por este cliente.");
    }
}
