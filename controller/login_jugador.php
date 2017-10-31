<?php
	//login de jugador: seteja la cookie $_COOKIE['jugador']
	include '../mysql.php';

	//entrada
	$id=$_GET['id'];			//id del jugador
	$password_provat=$_GET['pass'];	//password provat

	//busca el password de veritat	
	$sql="SELECT pass FROM jugadors WHERE id=$id";
	$res=$mysql->query($sql) or die('error');
	$row=mysqli_fetch_array($res);
	$pass=$row['pass'];

	if($pass==$password_provat)
	{
		setcookie('jugador',$id, time()+86400,'/') or exit("error setting cookie");
		echo "Contrasenya correcta<br>";
		header("location: ../jugador.php?id=$id");
	}
	else
	{
		echo("Contrasenya incorrecta<br>");
		die("<a href=".$_SERVER['HTTP_REFERER'].">Enrere</a>");
	}
?>
