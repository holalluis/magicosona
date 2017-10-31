<?php

/*
per fer en ajax:
inputs: id jugador, current password, nou password
*/

//connecta
include '../mysql.php';

//entrada
$id  = mysqli_real_escape_string($_POST['id']);  //jugador
$cur = mysqli_real_escape_string($_POST['cur']); //pswd actual
$nou = mysqli_real_escape_string($_POST['nou']); //pswd nou

if($id=="")die("error id jugador not set");
if($cur=="")die("error cur pswd not set");
if($nou=="")die("error nou pswd not set");

//si no admin o si !jugador o cookie==id, atura't
if(!isset($_COOKIE['admin'])) {
	if(!isset($_COOKIE['jugador'])) die('no permès');
	if($_COOKIE['jugador']!=$id) die('no permès');
}

//ordre
if($cur==current(mysqli_fetch_assoc($mysql->query("SELECT pass FROM jugadors WHERE id=$id"))))
{
	$sql="UPDATE jugadors SET pass='$nou' WHERE id=$id";
	$mysql->query($sql) or die('error');
	die('Password modificat correctament');
}
die('Error: password incorrecte');

?>
