<?php
include_once("Videoclub.php");
include_once("Cliente.php");

use DWES\Videoclub\Videoclub;

session_start();

if (!isset($_SESSION["videoclub"])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $user = $_POST["user"];
    $pass = $_POST["password"];
    $max = (int)$_POST["maxAlquileres"];
    $numero = (int)$_POST["numero"];

    if (!empty($nombre) && !empty($user) && !empty($pass) && $numero > 0) {
        $vc = $_SESSION["videoclub"];

        if ($vc->buscarPorNumSocio($numero) !== null) {
            header("Location: formCreateCliente.php?error=existe");
            exit();
        }

        $vc->incluirSocio($nombre, $max, $user, $pass, $numero);

        $_SESSION["videoclub"] = $vc;

        header("Location: mainAdmin.php");
        exit();
    } else {
        header("Location: formCreateCliente.php?error=datos");
        exit();
    }
}
header("Location: mainAdmin.php");