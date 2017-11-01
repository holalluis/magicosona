<?php
	$pass=$_GET['pass'];
	if($_GET['pass']=='delverofsecrets'){
		//seteja cookie i torna a la pagina anterior
		setcookie('admin',$pass,time()+86400,'/') or exit("error setting cookie");
		echo "Contrasenya correcta<br>";
		header("Location: ".$_SERVER['HTTP_REFERER']);
	}else{
		echo("Contrasenya incorrecta<br>Aquest incident serà reportat. Contrasenya intentada: $pass");
		mail('holalluis@gmail.com','intent accés a magicosona',"Contrasenya provada: $pass") or die('error mail');
		die("<a href='../index.php'>Pagina principal</a>");
	}
?>
