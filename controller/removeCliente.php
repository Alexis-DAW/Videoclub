<?php
include_once("../model/Videoclub.php");
include_once("../model/Cliente.php");
session_start();

if (!isset($_SESSION["videoclub"])) {
    header("Location: ../view/index.php");
    exit();
}

$vc = $_SESSION["videoclub"];

$numSocio = (int)($_GET["num"] ?? 0);

if ($numSocio > 0){
    try {
        $vc->eliminarSocio($numSocio);
        $_SESSION["videoclub"] = $vc;
    } catch (VideoclubException $e) {
        echo "<p style='color:red;'>⛔ ERROR: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color:red;'>⛔ ERROR: Número de socio no especificado o inválido.</p>";
}

echo ('<a href="../view/mainAdmin.php">Volver al panel de administración</a>');