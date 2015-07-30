<?php

if(!isset($_COOKIE['admin']) && !isset($_COOKIE['jugador']))
	die('sessio no iniciada');

include '../mysql.php';

$id=$_GET['id'];

//nou jugador
$sql="UPDATE ofertes SET quantitat=quantitat-1 WHERE id=$id";
mysql_query($sql) or die('error');
echo 'ok';

//torna enrere
header("Location: ".$_SERVER['HTTP_REFERER']);

?>
