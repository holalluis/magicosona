<?php include 'imports.php' ?>

<?php

if(!isset($_COOKIE['admin']))
	die('sessio no iniciada');

include 'mysql.php';

//entrada
$id_jugador=$_GET['id_jugador'];

//mira si el jugador ja està inscrit
$sql="SELECT * FROM assistentsProximTorneig WHERE id_jugador=$id_jugador";
$res=mysql_query($sql) or die('error');

if (mysql_num_rows($res) > 0)
	die('ERROR. El jugador ja està apuntat! <a href=assistents.php>Vés a la llista</a>');

//crea un nou assistent
$sql="INSERT INTO assistentsProximTorneig (id,id_jugador) VALUES (NULL,$id_jugador)";
mysql_query($sql) or die('error');

echo 'ok';

header('location: assistents.php');

?>
