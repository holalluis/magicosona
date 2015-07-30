<meta charset=utf-8>
<?php

if(!isset($_COOKIE['jugador']) && !isset($_COOKIE['admin']) )
	die('sessio no iniciada');

include '../mysql.php';

//entrada
$carta=mysql_real_escape_string($_POST['carta']);
$quantitat=$_POST['quantitat'];
$id_jugador=$_POST['id_jugador'];
$foil=$_POST['foil']=="on"? 1 : 0;
$preu=$_POST['preu'];

//crea una nova oferta
$sql="INSERT INTO ofertes (carta,quantitat,foil,id_jugador,preu) 
		   VALUES ('$carta',$quantitat,$foil,$id_jugador,$preu)";

mysql_query($sql) or die('error');

echo 'ok';

header("location: ../jugador.php?id=$id_jugador");

?>
