<?php
include_once("BaseDatos.php");
include_once("Cliente.php");
use DWES\Videoclub\Videoclub as Videoclub;
use DWES\Videoclub\Cliente as Cliente;

session_start();

$_SESSION["usuarios"] = [
    "usuario" => "usuario",
    "admin" => "admin",
    "amancio" => "amancio",
    "picasso" => "picasso"
];
$_SESSION["error"] = "";

$nombreIntroducido = $_POST["user"] ?? "";
$passIntroducida = $_POST["pass"] ?? "";

if (array_key_exists($nombreIntroducido, $_SESSION["usuarios"])){

    if($_SESSION["usuarios"][$nombreIntroducido] === $passIntroducida){
        $_SESSION["nombreUsuario"] = $nombreIntroducido;

        if (!isset($_SESSION["videoclub"])) {
            $vc = new Videoclub("Severo 8A");
            $vc->incluirJuego("God of War", 19.99, "PS4", 1, 1);
            $vc->incluirJuego("The Last of Us Part II", 49.99, "PS4", 1, 1);
            $vc->incluirDvd("Torrente", 4.5, "es","16:9");
            $vc->incluirDvd("Origen", 4.5, "es,en,fr", "16:9");
            $vc->incluirDvd("El Imperio Contraataca", 3, "es,en","16:9");
            $vc->incluirCintaVideo("Los cazafantasmas", 3.5, 107);
            $vc->incluirCintaVideo("El nombre de la Rosa", 1.5, 140);

            $vc->incluirSocio("Amancio Ortega", 3, "amancio", "amancio");
            $vc->incluirSocio("Pablo Picasso", 2, "picasso", "picasso");
            $vc->incluirSocio("Usuario Pruebas", 3, "usuario", "usuario");

            $vc->alquilarSocioProducto(1,2)->alquilarSocioProducto(1,3)
                ->alquilarSocioProducto(1,6);
            $_SESSION["videoclub"] = $vc;
        }

        $vc = $_SESSION["videoclub"];
        $clienteEncontrado = null;

        foreach ($vc->getSocios() as $cliente) {
            if ($cliente->getUser() === $nombreIntroducido) {
                $clienteEncontrado = $cliente;
                break;
            }
        }

        if ($nombreIntroducido === "admin"){
            header("Location: mainAdmin.php");
            exit();

        } else if ($clienteEncontrado) {
            $_SESSION["clienteActual"] = $clienteEncontrado;
            header("Location: mainCliente.php");
            exit();
        } else {
            // Usuario logeado pero que no es cliente/socio. Hay que redirigir.
            $_SESSION["error"] = "Error: El usuario '" . $nombreIntroducido . "' existe pero no es un socio del videoclub.";
            header("Location: index.php");
            exit();
        }

    } else {
        $_SESSION["error"] = "Nombre o contraseña incorrectas";
        header("Location: index.php");
        exit();
    }

} else {
    $_SESSION["error"] = "Nombre o contraseña incorrectas";
    header("Location: index.php");
    exit();
}