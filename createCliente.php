<?php
include_once("Videoclub.php");
include_once("Cliente.php");
session_start();

if (!isset($_SESSION["videoclub"]) || $_SESSION["nombreUsuario"] !== "admin") {
    header("Location: index.php");
    exit();
}

$vc = $_SESSION["videoclub"];

$nombre = $_POST["nombre"] ?? "";
$maxAlquiler = $_POST["maxAlquiler"] ?? 0;
$user = $_POST["user"] ?? "";
$pass = $_POST["pass"] ?? "";

if (empty($nombre) || $maxAlquiler < 1 || empty($user) || empty($pass)) {
    $_SESSION["error"] = "Todos los campos son obligatorios y el máximo de alquileres debe ser al menos 1.";
    header("Location: formCreateCliente.php");
    exit();
}

$usuarioExiste = false;
foreach ($vc->getSocios() as $cliente) {
    if ($cliente->getUser() === $user) {
        $usuarioExiste = true;
        break;
    }
}
if ($user === 'admin' || $usuarioExiste) {
    $_SESSION["error"] = "El nombre de usuario '$user' ya está en uso. Por favor, elige otro.";
    header("Location: formCreateCliente.php");
    exit();
}

try {
    $vc->incluirSocio($nombre, $maxAlquiler, $user, $pass);

    $_SESSION["videoclub"] = $vc;
    $_SESSION["error"] = "✅ Socio '$nombre' creado con éxito.";
    header("Location: mainAdmin.php");
    exit();

} catch (\Exception $e) {
    $_SESSION["error"] = "Error al intentar crear el socio: " . $e->getMessage();
    header("Location: formCreateCliente.php");
    exit();
}