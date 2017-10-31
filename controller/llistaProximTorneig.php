<?php

/*
per fer en ajax:
inputs: id jugador, camp a canviar, nou valor
*/

//connecta
include '../mysql.php';

//entrada
$id     = mysqli_real_escape_string($_POST['id']);
$llista = mysqli_real_escape_string($_POST['llista']);

//comprova admin
if(!isset($_COOKIE['admin']))
{
	//si admin no, comprova jugador
	if(!isset($_COOKIE['jugador']))
	{
		die('sessio no iniciada');
	}
	else
	{
		//comprova si el jugador és el correcte
		if($id != $_COOKIE['jugador'])
		{
			die('jugador incorrecte');
		}
	}
}

//si som aquí és que som admin o jugador

//ordre
$sql="UPDATE assistentsProximTorneig SET llista='$llista' WHERE id_jugador='$id'";
$mysql->query($sql) or die('error');

echo "Llista pujada correctament";

?>
