<?php
declare(strict_types=1);
class Soporte{
    private const IVA = 21;
    private static int $contador = 1; // 🔹 Contador autoincremental

    protected int $numero;
    private float $precio;
    public string $titulo;

    public function __construct(string $titulo, float $precio)
    {
        $this->titulo = $titulo;
        $this->precio = $precio;
        $this->numero = self::$contador++; // 🔹 Asigna y aumenta el número
    }
    public function getPrecio(): float
    {
        return $this->precio;
    }
    public function getNumero(): int
    {
        return $this->numero;
    }
    public function getPrecioConIva(){
        return $this->precio * (1 + self::IVA / 100);
    }

    public function muestraResumen(){
        echo "<br>$this->titulo 
              <br>$this->precio € (IVA no incluido)";
    }


}