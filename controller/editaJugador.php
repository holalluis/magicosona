<?php
/*
edita un camp d'un jugador
per fer en ajax:
inputs: id jugador, camp a canviar, nou valor
*/

//entrada
$id=$_GET['id'];
if($id=="")die('error: id jugador not set');

//si no admin o si !jugador o cookie==id, atura't
if(!isset($_COOKIE['admin']))
{
	if(!isset($_COOKIE['jugador'])) die('no permès');

	if($_COOKIE['jugador']!=$id) die('no permès');
}

//connecta
include '../mysql.php';

//entada
$camp     = mysqli_real_escape_string($_POST['camp']);
$nouValor = mysqli_real_escape_string($_POST['nouValor']);

//ordre
$sql="UPDATE jugadors SET $camp='$nouValor' WHERE id=$id";
$mysql->query($sql) or die('error');

//aquest text va a un alert del view 
echo "$camp actualitzat correctament a '$nouValor'";

?>
