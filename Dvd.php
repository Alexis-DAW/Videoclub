<?php
namespace Dwes\ProyectoVideoclub;
class Dvd extends Soporte{
    public string $idiomas;
    private string $formatoPantalla;

    public function __construct(string $titulo, float $precio, string $idiomas, string $formatoPantalla)
    {
        parent::__construct($titulo, $precio);
        $this->idiomas = $idiomas;
        $this->formatoPantalla = $formatoPantalla;
    }

    public function muestraResumen(){
        echo "Película en DVD:";
        parent::muestraResumen();
        echo "<br>Idiomas: " . $this->idiomas;
        echo "<br>Formato Pantalla: " . $this->formatoPantalla;
    }

}