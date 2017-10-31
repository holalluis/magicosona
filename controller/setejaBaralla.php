<?php

if(!isset($_COOKIE['jugador']) && !isset($_COOKIE['admin']))
	die('sessio no iniciada');

//seteja la columna 'baralla' en un resultat
include '../mysql.php';

//entrada
$id=$_GET['id'];		// id resultat
$baralla=$_GET['baralla'];	// id baralla

$sql="UPDATE resultats SET baralla='$baralla' WHERE id=$id";
$mysql->query($sql) or die('error');

//ves enrere
header("Location: ".$_SERVER['HTTP_REFERER']);

?>
