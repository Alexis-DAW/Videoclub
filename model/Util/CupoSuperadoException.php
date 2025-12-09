<?php
namespace DWES\Videoclub\Util;

include_once("VideoclubException.php");

class CupoSuperadoException extends VideoclubException{
    protected $message = "No se pudo alquilar: el cliente alcanzó el máximo de alquileres simultáneos.";
    protected $code = 402;

}