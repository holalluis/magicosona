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
$id     = $_COOKIE['jugador'];
$llista = mysql_real_escape_string($_POST['llista']);

//ordre
$sql="UPDATE assistentsProximTorneig SET llista='$llista' WHERE id_jugador=$id";
mysql_query($sql) or die('error');

echo "Llista pujada correctament";

?>
