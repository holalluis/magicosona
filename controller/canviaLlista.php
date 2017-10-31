<?php

//comprova jugador o admin
if(isset($_COOKIE['jugador'])==false && isset($_COOKIE['admin'])==false) 
	die('error: sessió no iniciada');

//connecta't
include '../mysql.php';

//processa id resultat & llista
$id=$_POST['id'];
$llista=$mysql->real_escape_string($_POST['llista']);

//si no ets admin...
if(!isset($_COOKIE['admin'])) {
	//comprova si la id del resultat coincideix amb la id del jugador cookie
	$id_jugador=current(mysqli_fetch_assoc($mysql->query("SELECT id_jugador FROM resultats WHERE id=$id")));
	//si el jugador que intenta canviar el resultat no és ell mateix atura't
	if($_COOKIE['jugador']!=$id_jugador)
		die("Error. No pots canviar la llista d'un altre jugador!");
}

//sql
$sql="UPDATE resultats SET llista='$llista' WHERE id=$id";
$mysql->query($sql) or die('error');

//resultat
echo "Llista actualitzada correctament";

?>
