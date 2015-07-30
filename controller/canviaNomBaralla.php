<?php

if(!isset($_COOKIE['admin']))
	die('sessio no iniciada');

include '../mysql.php';

//id baralla
$id=$_GET['id'];
$nouNom=mysql_real_escape_string($_GET['nom']);

//nou nom de baralla
$sql="UPDATE baralles SET nom='$nouNom' WHERE id=$id";

mysql_query($sql) or die('error');

echo "tot ok";

header("Location: ../baralles.php");

?>
