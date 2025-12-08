<?php
namespace DWES\Videoclub;

use DWES\Videoclub\Util\SoporteYaAlquiladoException;
use DWES\Videoclub\Util\VideoclubException;
use DWES\Videoclub\Util\ClienteNoEncontradoException;
use DWES\Videoclub\Util\SoporteNoEncontradoException;

include_once("Util\VideoclubException.php");

include_once("Soporte.php");
include_once("CintaVideo.php");
include_once("Dvd.php");
include_once("Juego.php");
include_once("Cliente.php");

class Videoclub {
    private string $nombre;
    private array $productos;
    private int $numProductos;
    private array $socios;
    private int $numSocios;
    private int $numProductosAlquilados;
    private int $numTotalAlquileres;

    public function __construct($nombre)
    {
        $this->nombre = $nombre;
        $this->productos = [];
        $this->numProductos = 0;
        $this->socios = [];
        $this->numSocios = 0;
        $this->numProductosAlquilados = 0;
        $this->numTotalAlquileres = 0;
    }

    public function getSocios(): array{
        return $this->socios;
    }

    public function getNombre(): string{
        return $this->nombre;
    }

    public function getNumTotalAlquileres(): int {
        return $this->numTotalAlquileres;
    }

    public function getNumProductosAlquilados(): int {
        return $this->numProductosAlquilados;
    }

    private function incluirProducto(Soporte $producto): void {
        $this->productos[] = $producto;
        $this->numProductos++;
    }
    public function incluirCintaVideo($titulo, $precio, $duracion): void {
        $this->incluirProducto(new CintaVideo($titulo, $precio, $duracion));
    }
    public function incluirDvd($titulo, $precio, $idiomas, $pantalla): void {
        $this->incluirProducto(new Dvd($titulo, $precio, $idiomas, $pantalla));
    }
    public function incluirJuego($titulo, $precio, $consola, $minJ, $maxJ): void {
        $this->incluirProducto(new Juego($titulo, $precio, $consola, $minJ, $maxJ));
    }

    public function incluirSocio(string $nombre, int $maxAlquilerConcurrente=3, string $user, string $pass, int $numeroCliente = 0): void {

        $socio = new Cliente($nombre, $maxAlquilerConcurrente, $user, $pass, $numeroCliente);
        $this->socios[] = $socio;
        $this->numSocios++;
    }

    public function buscarPorNumSocio(int $numSocio): ?Cliente {
        foreach ($this->socios as $socio){
            if($socio->getNumero() === $numSocio){
                return $socio;
            }
        }
        return null;
    }
    public function eliminarSocio(int $numSocio){
        $socioAEliminar = $this->buscarPorNumSocio($numSocio);

        if (!$socioAEliminar) {
            throw new ClienteNoEncontradoException("No se encontró socio con el número: $numSocio.");
        }

        $this->socios = array_filter($this->socios, fn($socio) => $socio->getNumero() !== $numSocio);
        $this->numSocios--;

        echo "<p style='color:green;'>✅ Socio número $numSocio ({$socioAEliminar->nombre}) eliminado correctamente.</p>";

        return $this;
    }

    public function listarProductos(): void{
        echo "<strong>Listado de los " . count($this->productos) . " productos disponibles:</strong>";
        foreach ($this->productos as $producto) {
            echo "<br>" . $producto->getNumero() . ".- ";
            $producto->muestraResumen();
            echo "<br>";
        }
    }

    public function listarSocios(): void{
        echo "<strong>Listado de " . $this->numSocios . " socios del videoclub:</strong><br>";
        echo "<ul>";
        foreach ($this->socios as $socio){
            echo "<li>";
            echo "<strong>" . $socio->nombre . "</strong> (User: " . $socio->getUser() . ")";
            echo " | <a href='formUpdateCliente.php?num=" . $socio->getNumero() . "'>Editar</a>";
            echo " | <a href='removeCliente.php?num=" . $socio->getNumero() .
                "' onclick='return confirm(\"¿Estás seguro de que quieres eliminar al socio " .
                $socio->nombre . "?\");'>Borrar</a>";
            echo "</li>";
        }
        echo "</ul>";
    }

    public function alquilarSocioProducto($numeroCliente, $numeroSoporte): Videoclub{
        try {
            $socio = null;
            foreach ($this->socios as $s){
                if ($s->getNumero() === $numeroCliente){
                    $socio = $s;
                    break;
                }
            }

            $soporte = null;
            foreach ($this->productos as $p){
                if ($p->getNumero() === $numeroSoporte){
                    $soporte = $p;
                    break;
                }
            }

            if (!$socio) throw new ClienteNoEncontradoException();
            if (!$soporte) throw new SoporteNoEncontradoException();

            $socio->alquilar($soporte);
            $this->numProductosAlquilados++;
            $this->numTotalAlquileres++;
            return $this;

        }catch(VideoclubException $e){
            echo "<p style='color:red;'>⛔ ERROR: " . $e->getMessage() . "</p>";
        }
        return $this;
    }

    public function alquilarSocioProductos(int $numeroCliente, array $numerosSoportes): Videoclub {
        try {
            $socio = null;
            foreach ($this->socios as $s){
                if ($s->getNumero() === $numeroCliente){
                    $socio = $s;
                    break;
                }
            }
            if (!$socio) throw new ClienteNoEncontradoException("Socio con número $numeroCliente no encontrado.");

            $soportesParaAlquilar = [];
            foreach ($numerosSoportes as $numSoporte) {
                $soporteEncontrado = null;

                foreach ($this->productos as $p){
                    if ($p->getNumero() === $numSoporte){
                        $soporteEncontrado = $p;
                        break;
                    }
                }
                if (!$soporteEncontrado) throw new SoporteNoEncontradoException();
                if ($soporteEncontrado->alquilado) throw new SoporteYaAlquiladoException();

                $soportesParaAlquilar[] = $soporteEncontrado;
            }

            $numNuevosAlquileres = count($soportesParaAlquilar);
            $cupoMaximo = $socio->getMaxAlquilerConcurrente();
            $alquileresActuales = $socio->getNumSoportesAlquilados();

            if (($alquileresActuales + $numNuevosAlquileres) > $cupoMaximo) {
                throw new CupoSuperadoException("La solicitud excede el cupo de {$socio->nombre} de $cupoMaximo. 
                Solicitados: $numNuevosAlquileres.");
            }

            foreach ($soportesParaAlquilar as $soporte) {
                $socio->alquilar($soporte);
                $this->numProductosAlquilados++;
                $this->numTotalAlquileres++;
            }

            echo "<p>✅ Alquiler múltiple exitoso para {$socio->nombre}. Productos alquilados: $numNuevosAlquileres.</p>";
            return $this;

        } catch (VideoclubException $e) {
            echo "<p style='color:red;'>⛔ ERROR en el alquiler: " . $e->getMessage() . " No se alquiló ningún producto.</p>";
        }
        return $this;
    }

    public function devolverSocioProducto(int $numeroCliente, int $numeroSoporte): Videoclub{
        try {
            $socio = null;
            foreach ($this->socios as $s){
                if ($s->getNumero() === $numeroCliente){
                    $socio = $s;
                    break;
                }
            }
            if (!$socio) {
                throw new ClienteNoEncontradoException();
            }
            $socio->devolver($numeroSoporte);

            $this->numProductosAlquilados--;
            echo "<p>✅ Devolución exitosa: Soporte $numeroSoporte por $socio->nombre.</p>";

        } catch(VideoclubException $e){
            echo "<p style='color:red;'>⛔ ERROR en la devolución: " . $e->getMessage() . "</p>";
        }
        return $this;
    }

    public function devolverSocioProductos(int $numeroCliente, array $numerosSoportes): Videoclub{
        try {
            $socio = null;
            foreach ($this->socios as $s){
                if ($s->getNumero() === $numeroCliente){
                    $socio = $s;
                    break;
                }
            }
            if (!$socio) throw new ClienteNoEncontradoException();

            $devolucionesExitosas = 0;
            foreach ($numerosSoportes as $numSoporte) {
                try {
                    $socio->devolver($numSoporte);
                    $this->numProductosAlquilados--;
                    $devolucionesExitosas++;
                } catch (SoporteNoEncontradoException $e) {
                    echo "<p style='color:orange;'>⚠️ ADVERTENCIA: " . $e->getMessage() .
                         "Se omite este soporte y se continúa.</p>";
                }
            }

            echo "<p>✅ Devolución múltiple finalizada. Devoluciones exitosas: $devolucionesExitosas.</p>";

        } catch(ClienteNoEncontradoException $e){
            echo "<p style='color:red;'>⛔ ERROR: " . $e->getMessage() . "</p>";
        }
        return $this;
    }

}