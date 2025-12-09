<?php
include_once("../model/BaseDatos.php");
session_start();

if (!isset($_SESSION["videoclub"]) || !isset($_SESSION["nombreUsuario"])) {
    header("Location: index.php");
    exit();
}

$cliente = $_SESSION["clienteActual"];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>mainCliente</title>
</head>
<body>

<h1>¡Bienvenido, <?= $cliente->nombre ?>! 🎬
    Videoclub <?= $_SESSION["videoclub"]->getNombre() ?></h1>

<h2>Tus alquileres:</h2>
<?php
$alquileres = $cliente->getSoportesAlquilados();

if (empty($alquileres)) {
    echo "<p>No tienes soportes alquilados actualmente.</p>";
} else {
    echo "<ul>";
    foreach ($alquileres as $alquiler){
        echo "<li>";
        $alquiler->muestraResumen();
        echo "</li>";
    }
    echo "</ul>";
}
?>

<br>
<a href="formUpdateCliente.php?num=<?= $cliente->getNumero() ?>">📝 Editar mis datos</a>
<br><br>

<a href="../controller/logout.php">Cerrar sesión</a>

</body>
</html>