<?php
include_once("BaseDatos.php");
session_start();

if (!isset($_SESSION["videoclub"]) || !isset($_SESSION["nombreUsuario"])) {
    header("Location: index.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>mainAdmin</title>
</head>
<body>
    <h1>¡Bienvenido, <?= $_SESSION["nombreUsuario"] ?? "" ?>! 🎬
        Videoclub <?= $_SESSION["videoclub"]->getNombre() ?></h1>

    <?php $_SESSION["videoclub"]->listarSocios() ?> <br>

    <?php $_SESSION["videoclub"]->listarProductos() ?> <br>

    <a href="index.php">Cerrar sesión</a>

</body>
</html>
