<?php
include_once("Videoclub.php");
include_once("Cliente.php");
session_start();

if (!isset($_SESSION["videoclub"]) || !isset($_SESSION["nombreUsuario"])) {
    header("Location: index.php");
    exit();
}

$vc = $_SESSION["videoclub"];
$usuarioActual = $_SESSION["nombreUsuario"];
$numSocioSolicitado = (int)($_GET['num'] ?? 0);

$clienteEditar = null;


if ($usuarioActual === 'admin') {
    $clienteEditar = $vc->buscarPorNumSocio($numSocioSolicitado);
}
else if (isset($_SESSION["clienteActual"])) {
    $clienteLogueado = $_SESSION["clienteActual"];
    if ($clienteLogueado->getNumero() === $numSocioSolicitado) {
        $clienteEditar = $clienteLogueado;
    } else {
        die("No tienes permisos para editar este perfil.");
    }
}

if (!$clienteEditar) {
    echo "Cliente no encontrado o no tienes permisos.";
    echo "<br><a href='index.php'>Volver</a>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
</head>
<body>
<h1>Editar datos de: <?= $clienteEditar->nombre ?></h1>

<form action="updateCliente.php" method="POST">
    <input type="hidden" name="numeroOriginal" value="<?= $clienteEditar->getNumero() ?>">

    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?= $clienteEditar->nombre ?>" required><br><br>

    <label>Usuario:</label><br>
    <input type="text" name="user" value="<?= $clienteEditar->getUser() ?>" required><br><br>

    <label>Contraseña:</label><br>
    <input type="text" name="password" value="<?= $clienteEditar->getPassword() ?>" required><br><br>

    <input type="submit" value="Actualizar Datos">
</form>
<br>

<?php if ($usuarioActual === 'admin'): ?>
    <a href="mainAdmin.php">Volver al Panel Admin</a>
<?php else: ?>
    <a href="mainCliente.php">Volver a Mi Perfil</a>
<?php endif; ?>
</body>
</html>