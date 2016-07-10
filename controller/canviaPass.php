<?php

/*
per fer en ajax:
inputs: id jugador, current password, nou password
*/

//comprova cookies
if(!isset($_COOKIE['jugador'])) die('sessio no iniciada');

//connecta
include '../mysql.php';

//entada
$id  = $_COOKIE['jugador'];
$cur = mysql_real_escape_string($_POST['cur']);
$nou = mysql_real_escape_string($_POST['nou']);

//ordre
if($cur==current(mysql_fetch_assoc(mysql_query("SELECT pass FROM jugadors WHERE id=$id"))))
{
	$sql="UPDATE jugadors SET pass='$nou' WHERE id=$id";
	mysql_query($sql) or die('error');
	die('Password modificat correctament');
}
die('Error: password incorrecte');

?>
