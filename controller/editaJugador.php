<?php

/*
per fer en ajax:
inputs: id jugador, camp a canviar, nou valor
*/

//comprova cookies
if(!isset($_COOKIE['jugador'])) die('sessio no iniciada');

//connecta
include '../mysql.php';

//entada
$id       = $_COOKIE['jugador'];
$camp     = mysql_real_escape_string($_POST['camp']);
$nouValor = mysql_real_escape_string($_POST['nouValor']);

//ordre
$sql="UPDATE jugadors SET $camp='$nouValor' WHERE id=$id";
mysql_query($sql) or die('error');

//aquest text va a un alert del view 
echo "$camp actualitzat correctament a '$nouValor'";

?>
