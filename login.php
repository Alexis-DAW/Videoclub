<?php
session_start();
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