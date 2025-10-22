<?php
class Juego extends Soporte {

    public function __construct(
        string $titulo,
        int $numero,
        float $precio,
        public string $consola,
        private int $minNumJugadores,
        private int $maxNumJugadores
    )
    {
        parent::__construct($titulo, $numero, $precio);
    }

    public function muestraJugadoresPosibles(){
        if($this->minNumJugadores === 1 && $this->maxNumJugadores === 1){
            echo "Para un jugador";
        } else if ($this->minNumJugadores > 1 && $this->maxNumJugadores===$this->minNumJugadores) {
            echo "Para $this->minNumJugadores jugadores";
        } else {
            echo "De $this->minNumJugadores a $this->maxNumJugadores jugadores";
        }
    }

    public function muestraResumen(){
        echo "<br>Juego para: $this->consola<br>";
        parent::muestraResumen();
        $this->muestraJugadoresPosibles();
    }

}