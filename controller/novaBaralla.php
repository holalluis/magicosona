<?php

if(!isset($_COOKIE['admin']))
	die('sessio no iniciada');

include '../mysql.php';

$nom=mysql_real_escape_string($_GET['nom']);

//nou jugador
$sql="INSERT INTO baralles (nom) VALUES ('$nom')";
mysql_query($sql) or die('error');

echo 'nova baralla ok';

header("Location: ../baralles.php");

?>
