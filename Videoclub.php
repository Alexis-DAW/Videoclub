<?php
include_once("Soporte.php");
include_once("CintaVideo.php");
include_once("Dvd.php");
include_once("Juego.php");
include_once("Cliente.php");

class Videoclub
{
    private string $nombre;
    private array $productos;
    private int $numProductos;
    private array $socios;
    private int $numSocios;

    public function __construct($nombre)
    {
        $this->nombre = $nombre;
        $this->productos = [];
        $this->numProductos = 0;
        $this->socios = [];
        $this->numSocios = 0;
    }

    private function incluirProducto(Soporte $producto): void {
        $this->productos[] = $producto;
        $this->numProductos++;
        echo "Incluido soporte " . $this->numProductos . "<br>";
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

    public function incluirSocio($nombre, $maxAlquileresConcurrentes = 3): void {
        $this->socios[] = new Cliente($nombre, $maxAlquileresConcurrentes);
        $this->numSocios++;
        echo "Incluido socio " . $this->numSocios . "<br>";
    }

    public function listarProductos(): void{
        echo "<br>Listado de los " . count($this->productos) . " productos disponibles:";
        foreach ($this->productos as $producto) {
            echo "<br>" . $producto->getNumero() . ".- ";
            $producto->muestraResumen();
        }
    }
    public function listarSocios(): void{
        echo "<br><br>Listado de " . $this->numSocios . " socios del videoclub:<br>";
        foreach ($this->socios as $socio){
            $socio->muestraResumen();
            echo "<br>";
        }
    }

    public function alquilarSocioProducto($numeroCliente, $numeroSoporte){
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

        if ($socio && $soporte){
            $socio->alquilar($soporte);
        } else {
            echo "ERROR. Socio o soporte no encontrados.";
        }

    }

}