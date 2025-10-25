<?php
include_once "Soporte.php";
class CintaVideo extends Soporte {
    private int $duracion;

    public function __construct(string $titulo, float $precio, int $duracion)
    {
        parent::__construct($titulo, $precio);
        $this->duracion = $duracion;
    }

    public function muestraResumen(){
        echo "Película en VHS:";
        parent::muestraResumen();
        echo "<br>Duración: $this->duracion minutos";
    }

}