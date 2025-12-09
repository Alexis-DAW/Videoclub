<?php
namespace DWES\Videoclub\Util;

include_once("VideoclubException.php");
class ClienteNoEncontradoException extends VideoclubException{
    protected $message = "El cliente (socio) buscado no se ha encontrado en el videoclub.";
    protected $code = 404;

}