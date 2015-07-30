<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
<?php
	include 'mysql.php';
	//login de jugador: seteja la cookie $_COOKIE['jugador']

	//entrada
	$id = $_GET['id'];			//id del jugador
	$password_provat = $_GET['pass'];	//password provat

	//busca el password de veritat	
	$sql="SELECT pass FROM jugadors WHERE id=$id";
	$res=mysql_query($sql) or die('error');
	$row=mysql_fetch_array($res);
	$pass=$row['pass'];

	if($pass==$password_provat)
	{
		setcookie('jugador',$id, time()+86400,'/') or exit("error setting cookie");
		echo "Contrasenya correcta<br>";
		header("Location: jugador.php?id=$id");
	}
	else
	{
		echo("Contrasenya incorrecta<br>");
		die("<a href=".$_SERVER['HTTP_REFERER'].">Enrere</a>");
	}
?>
