<?php
namespace DWES\Videoclub\Util;
include_once("VideoclubException.php");

class SoporteNoEncontradoException extends VideoclubException{
    protected $message = "No se pudo alquilar: Soporte no encontrado.";
    protected $code = 403;

}