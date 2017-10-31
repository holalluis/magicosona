<?php

if(!isset($_COOKIE['admin']))
	die('sessio no iniciada');

include '../mysql.php';

//entrada
$id =$_GET['id'];

//esborra jugador
$sql="DELETE FROM jugadors WHERE id=$id";
$mysql->query($sql) or die('error');

//esborra resultats
$sql="DELETE FROM resultats WHERE id_jugador=$id";
$mysql->query($sql) or die('error');

//esborra si esta a la llista d'assistents
$sql="DELETE FROM assistentsProximTorneig WHERE id_jugador=$id";
$mysql->query($sql) or die('error');

echo "Jugador esborrat correctament";
header("Location: ../index.php");

?>

