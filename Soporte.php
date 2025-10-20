<?php
declare(strict_types=1);
class Soporte{
    private static int $IVA = 21;
    public function __construct(
        public string $titulo,
        protected int $numero,
        private float $precio
    ){}
    public function getPrecio(): float
    {
        return $this->precio;
    }
    public function getNumero(): int
    {
        return $this->numero;
    }
    public function getPrecioConIva(){
        return $this->precio * (1+ self::$IVA / 100);
    }

    public function muestraResumen(){
        echo "<br>$this->titulo con el nº$this->numero: $this->precio €";
    }


}