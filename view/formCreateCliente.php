<?php
include_once("../model/Videoclub.php");
include_once("../model/Cliente.php");
session_start();

if (!isset($_SESSION["videoclub"]) || !isset($_SESSION["nombreUsuario"]) || $_SESSION["nombreUsuario"] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Crear Cliente</title>
    </head>
    <body>
        <h1>Dar de alta nuevo cliente</h1>
        <?php if(isset($_GET['error'])) echo "<p style='color:red'>Error: Revisa los datos.</p>"; ?>

        <form action="../controller/createCliente.php" method="POST">
            <label>Nombre:</label><br>
            <input type="text" name="nombre" required><br><br>

            <label>Usuario:</label><br>
            <input type="text" name="user" required><br><br>

            <label>Contraseña:</label><br>
            <input type="password" name="password" required><br><br>

            <label>Límite Alquileres:</label><br>
            <input type="number" name="maxAlquileres" value="3" min="1"><br><br>

            <label>Número de Socio:</label><br>
            <input type="number" name="numero" required><br><br>

            <input type="submit" value="Crear">
        </form>
        <br>
        <a href="mainAdmin.php">Volver</a>
    </body>
</html>