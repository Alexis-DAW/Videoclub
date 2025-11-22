<?php
namespace DWES\Videoclub\Util;

include_once("VideoclubException.php");

class SoporteYaAlquiladoException extends VideoclubException{
    protected $message = "Este soporte ya está alquilado.";  // Mensaje por defecto
    protected $code = 401;

}