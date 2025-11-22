<?php
include_once "Videoclub.php"; // No incluimos nada más

use Dwes\ProyectoVideoclub\Videoclub;

$vc = new Videoclub("Severo 8A");

//voy a incluir unos cuantos soportes de prueba
$vc->incluirJuego("God of War", 19.99, "PS4", 1, 1);
$vc->incluirJuego("The Last of Us Part II", 49.99, "PS4", 1, 1);
$vc->incluirDvd("Torrente", 4.5, "es","16:9");
$vc->incluirDvd("Origen", 4.5, "es,en,fr", "16:9");
$vc->incluirDvd("El Imperio Contraataca", 3, "es,en","16:9");
$vc->incluirCintaVideo("Los cazafantasmas", 3.5, 107);
$vc->incluirCintaVideo("El nombre de la Rosa", 1.5, 140);

//listo los productos
$vc->listarProductos();
echo "<br><br>";

//voy a crear algunos socios
$vc->incluirSocio("Amancio Ortega");
$vc->incluirSocio("Pablo Picasso", 2);

$vc->alquilarSocioProducto(1,2)->alquilarSocioProducto(1,3)->alquilarSocioProducto(1,2)->alquilarSocioProducto(1,6);

//listo los socios
$vc->listarSocios();