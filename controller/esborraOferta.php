<?php

if(!isset($_COOKIE['admin']) && !isset($_COOKIE['jugador']) )
	die('sessio no iniciada');

include '../mysql.php';

//entrada: oferta id
$id=$_GET['id'];

//esborra oferta
$sql="DELETE FROM ofertes WHERE id=$id";
mysql_query($sql) or die('error');

echo "Oferta esborrada correctament";

header("Location: ".$_SERVER['HTTP_REFERER']);

?>

