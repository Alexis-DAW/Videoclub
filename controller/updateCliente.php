<?php
include_once("../model/Videoclub.php");
include_once("../model/Cliente.php");

session_start();

if (isset($_SESSION["videoclub"])) {
    $num = (int)$_POST["numeroOriginal"];
    $nombre = $_POST["nombre"];
    $user = $_POST["user"];
    $pass = $_POST["password"];

    $vc = $_SESSION["videoclub"];
    $usuarioActual = $_SESSION["nombreUsuario"];

    $cliente = $vc->buscarPorNumSocio($num);


    $esAdmin = ($usuarioActual === 'admin');
    $esPropietario = (isset($_SESSION["clienteActual"]) && $_SESSION["clienteActual"]->getNumero() === $num);

    if ($cliente && ($esAdmin || $esPropietario)) {
        $cliente->setNombre($nombre);
        $cliente->setUser($user);
        $cliente->setPassword($pass);

        $_SESSION["videoclub"] = $vc;

        if ($esAdmin) {
            header("Location: ../view/mainAdmin.php");
        } else {
            $_SESSION["clienteActual"] = $cliente;
            header("Location: ../view/mainCliente.php");
        }
        exit();
    } else {
        echo "Error: No tienes permisos para realizar esta acción.";
    }
}