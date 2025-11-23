<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>main</title>
</head>
<body>
    <h1>¡Bienvenido, <?= $_SESSION["nombreUsuario"] ?? "" ?>!</h1>
    <br>
    <a href="index.php">Cerrar sesión</a>

</body>
</html>
