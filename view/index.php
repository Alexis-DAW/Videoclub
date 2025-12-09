<?php
session_start();
$error = "";

if (isset($_SESSION["error"])){
    $error = $_SESSION["error"];
    unset($_SESSION["error"]);
    }


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>index.php</title>
    <style>
        .error{
            color: red;
        }
    </style>
</head>
<body>

    <form action="../controller/login.php" method="post">
        <fieldset>
            <legend>Inicio de sesión</legend>
            <label for="user">Usuario:</label>
            <input type="text" id="user" name="user" required> ||||

            <label for="pass">Contraseña:</label>
            <input type="password" id="pass" name="pass" required> ----

            <button type="submit">Acceder</button>
            <div class="error"><?= $error ?? "" ?></div>
        </fieldset>
    </form>

</body>
</html>
