<?php
session_start();
$error = $_SESSION["error"] ?? "";
unset($_SESSION["error"]);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alta de Cliente</title>
    <style>.error{color: red;}</style>
</head>
<body>
    <h1>👤 Nuevo Socio del Videoclub</h1>
    <form action="createCliente.php" method="post">
        <label for="nombre">Nombre Completo:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="maxAlquiler">Máx. Alquileres Concurrentes (mín. 1):</label>
        <input type="number" id="maxAlquiler" name="maxAlquiler" min="1" value="3" required><br><br>

        <label for="user">Usuario (Login):</label>
        <input type="text" id="user" name="user" required><br><br>

        <label for="pass">Contraseña:</label>
        <input type="password" id="pass" name="pass" required><br><br>

        <button type="submit">Dar de Alta Socio</button>
        <div class="error"><?= $error ?></div>
    </form>
    <br><a href="mainAdmin.php">Volver al Panel de Administración</a>
</body>
</html>