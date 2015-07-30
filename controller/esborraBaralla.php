<?php

if(!isset($_COOKIE['admin']))
	die('sessio no iniciada');

include '../mysql.php';

//entrada: baralla id
$id=$_GET['id'];

//esborra esdeveniment
$sql="DELETE FROM baralles WHERE id=$id";
mysql_query($sql) or die('error');

echo "Baralla esborrada correctament";

header("Location: ../baralles.php");

?>

