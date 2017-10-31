<?php include 'imports.php' ?>

<?php

include 'mysql.php';

//entrada
$id_jugador=$_GET['id_jugador'];

//mira si el jugador ja està inscrit
$sql="SELECT * FROM assistentsProximTorneig WHERE id_jugador=$id_jugador";
$res=$mysql->query($sql) or die('error');

if (mysqli_num_rows($res) > 0)
	die('ERROR. El jugador ja està apuntat! <a href=assistents.php>Vés a la llista</a>');

//crea un nou assistent
$sql="INSERT INTO assistentsProximTorneig (id,id_jugador) VALUES (NULL,$id_jugador)";
$mysql->query($sql) or die('error');

echo 'ok';

//notifica per mail
/*
$nom=current(mysqli_fetch_assoc($mysql->query("SELECT nom FROM jugadors WHERE id=$id_jugador")));
mail("holalluis@gmail.com","$nom assistirà al pròxim torneig","aaa") or die('error mail');
*/

header('location: assistents.php');

?>
