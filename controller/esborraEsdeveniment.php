<?php

if(!isset($_COOKIE['admin'])) die('sessio no iniciada');

include '../mysql.php';

//entrada
$id=$_GET['id'];

//esborra resultats
$sql="DELETE FROM resultats WHERE id_esdeveniment=$id";
mysql_query($sql) or die('error');

//esborra esdeveniment
$sql="DELETE FROM esdeveniments WHERE id=$id";
mysql_query($sql) or die('error');

echo "Esdeveniment esborrat correctament";

header("Location: ../index.php");

?>

