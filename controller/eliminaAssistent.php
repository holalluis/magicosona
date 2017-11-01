<?php

// ELIMINAR UN ASSISTENT AL PROXIM TORNEIG DE LA BASE DE DADES

//entrada
$id=$_GET['id_jugador'];
if(empty($id))die('error: id jugador not set');

//si no admin o si !jugador o cookie==id, atura't
if(!isset($_COOKIE['admin']))
{
	if(!isset($_COOKIE['jugador'])) die('no permès');

	if($_COOKIE['jugador']!=$id) die('no permès');
}
include '../mysql.php';

//elimina assistent
$sql="DELETE FROM assistentsProximTorneig WHERE id_jugador=$id";
$mysql->query($sql) or die('error');
echo 'ok';

//torna
header("location: ".$_SERVER['HTTP_REFERER']);

?>
