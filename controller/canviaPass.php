<?php

/*
per fer en ajax:
inputs: id jugador, current password, nou password
*/

//entrada
$id  = $_COOKIE['jugador'];
$cur = mysql_real_escape_string($_POST['cur']);
$nou = mysql_real_escape_string($_POST['nou']);

if($id=="")die('error id jugador not set');
if($cur=="")die('error cur pswd not set');
if($nou=="")die('error nou pswd not set');

//si no admin o si !jugador o cookie==id, atura't
if(!isset($_COOKIE['admin']))
{
	if(!isset($_COOKIE['jugador'])) die('no permès');

	if($_COOKIE['jugador']!=$id) die('no permès');
}

//connecta
include '../mysql.php';

//ordre
if($cur==current(mysql_fetch_assoc(mysql_query("SELECT pass FROM jugadors WHERE id=$id"))))
{
	$sql="UPDATE jugadors SET pass='$nou' WHERE id=$id";
	mysql_query($sql) or die('error');
	die('Password modificat correctament');
}
die('Error: password incorrecte');

?>
