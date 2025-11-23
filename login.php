<?php
session_start();
include_once("BaseDatos.php");
use DWES\Videoclub\Videoclub as Videoclub;

$_SESSION["usuarios"] = [
    "usuario" => "usuario",
    "admin" => "admin"
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

            $vc->incluirSocio("Amancio Ortega");
            $vc->incluirSocio("Pablo Picasso", 2);

            $vc->alquilarSocioProducto(1,2)->alquilarSocioProducto(1,3)
                ->alquilarSocioProducto(1,6);

            $_SESSION["videoclub"] = $vc;
        }

        header("Location: main.php");
        exit();
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