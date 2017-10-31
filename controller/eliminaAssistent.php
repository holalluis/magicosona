<?php

// ELIMINAR UN ASSISTENT AL PROXIM TORNEIG DE LA BASE DE DADES

if(!isset($_COOKIE['admin']))
	die('sessio no iniciada');

include '../mysql.php';

//entrada
$id_jugador=$_GET['id_jugador'];

//elimina assistent
$sql="DELETE FROM assistentsProximTorneig WHERE id_jugador=$id_jugador";

$mysql->query($sql) or die('error');

echo 'ok';

header('location: ../assistents.php');

?>
