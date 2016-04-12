<?php 
	include 'mysql.php'; 
	include 'dataProximTorneig.php';
?>
<!doctype html>
<html>
<head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet type="text/css" href="estils.css" />
	<title>Magic Osona - Login</title>
</head><body><center>
<?php include 'menu.php' ?>

<div style="margin:0;background-color:#395693;color:white;padding:0.5em">
<?php
	if(isset($_COOKIE['admin']))
	{ ?>
		Sessió iniciada com a ADMINISTRADOR | <a href="controller/logout.php" style=color:white>Finalitza sessió</a>
	<?php }
	else if(isset($_COOKIE['jugador']))
	{
		$sql="SELECT nom FROM jugadors WHERE id=".$_COOKIE['jugador'];
		$ress=mysql_query($sql) or die('error');
		$roww=mysql_fetch_assoc($ress);
		$nom=$roww['nom'];
		echo "Sessió iniciada com a 
			<a style=color:white href=jugador.php?id=".$_COOKIE['jugador'].">$nom</a>";
		echo " <button onclick=window.location='controller/logout.php'>Finalitza sessió</button>";
	}
	else
	{
		echo "<i>Sessió no iniciada </i>";
		echo " <select onchange=window.location='jugador.php?id='+this.value>";
		echo "<option>--SELECCIONA--";
		$res=mysql_query("SELECT * FROM jugadors ORDER BY nom ASC");
		while($roww=mysql_fetch_assoc($res)) echo "<option value=".$roww['id'].">".$roww['nom'];
		echo "</select>";
	}
?>
</div>
