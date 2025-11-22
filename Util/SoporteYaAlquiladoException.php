<?php
namespace DWES\Videoclub\Util;

include_once("VideoclubException.php");

class SoporteYaAlquiladoException extends VideoclubException{
    protected $message = "Soporte ya alquilado por este cliente.";  // Mensaje por defecto
    protected $code = 401;

}