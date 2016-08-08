<?php 
	include 'mysql.php'; 
	include 'dataProximTorneig.php';
?>
<!doctype html><html><head><?php include'imports.php'?>
	<title>Login</title>
</head><body><center>
<?php include'menu.php'?>

<div style="margin:0;background-color:#395693;color:white;padding:3em 0.5em">
<?php
	if(isset($_COOKIE['admin']))
	{ ?>
		Sessió iniciada com a ADMINISTRADOR
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
		echo "<i>Inicia la sessió</i>&emsp;";
		echo " <select onchange=window.location='jugador.php?id='+this.value>";
		echo "<option>--Selecciona el teu nom--";
		$res=mysql_query("SELECT * FROM jugadors ORDER BY nom ASC");
		while($roww=mysql_fetch_assoc($res)) echo "<option value=".$roww['id'].">".$roww['nom'];
		echo "</select>";
	}
?>
</div>

<script>
function login()
{
	var p=prompt('Contrasenya?')
	if(p) window.location='controller/login.php?pass='+p
}
</script>
<br><a href=# onclick=login()>Admin</a>
