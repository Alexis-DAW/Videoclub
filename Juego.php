<?php
namespace Dwes\ProyectoVideoclub;
class Juego extends Soporte {

    public string $consola;
    private int $minNumJugadores;
    private int $maxNumJugadores;

    public function __construct(string $titulo, float $precio, string $consola, int $minNumJugadores, int $maxNumJugadores)
    {
        parent::__construct($titulo, $precio);
        $this->consola = $consola;
        $this->minNumJugadores = $minNumJugadores;
        $this->maxNumJugadores = $maxNumJugadores;
    }

    public function muestraJugadoresPosibles(){
        if($this->minNumJugadores === 1 && $this->maxNumJugadores === 1){
            echo "<br>Para un jugador";
        } else if ($this->minNumJugadores > 1 && $this->maxNumJugadores===$this->minNumJugadores) {
            echo "<br>Para $this->minNumJugadores jugadores";
        } else {
            echo "<br>De $this->minNumJugadores a $this->maxNumJugadores jugadores";
        }
    }

    public function muestraResumen(){
        echo "Juego para: $this->consola";
        parent::muestraResumen();
        $this->muestraJugadoresPosibles();
    }

}