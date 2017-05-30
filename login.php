<?php 
	include 'mysql.php'; 
	include 'dataProximTorneig.php';
?>
<!doctype html><html><head><?php include'imports.php'?>
	<title>Login</title>
	<script>
		function init()
		{
			//focus a username
			var input=document.querySelector('#nom_jugador')
			if(input)input.focus()
		}
	</script>
</head><body onload=init()><center>
<?php include'menu.php'?>

<div id=form style="margin:0;background-color:#395693;color:white;padding:3em 0.5em">
	<style>
		#form input {max-width:40%}
	</style>
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
		echo "<i>Selecciona el teu nom i escriu la contrasenya</i><br><br>";
		echo "<select id=id_jugador>";
		$sql="SELECT * FROM jugadors ORDER BY nom ASC";
		$ress=mysql_query($sql) or die('error');
		while($roww=mysql_fetch_assoc($ress))
		{
			$nom=$roww['nom'];
			$idd=$roww['id'];
			echo "<option value=$idd>$nom";
		}
		echo "</select>";
		echo " <input id=pass type=password maxlength=20 placeholder=Contrasenya onkeydown=buscaEnter(event)>";
		echo " <button onclick=login_jugador()>ok</button>";
		echo "<div style=padding-top:1em;font-size:14px>
			<a href=recuperar.php style='color:white;margin-left:5px'>No recordo la contrasenya</a>
		</div>";
	}
?>
</div>

<div style="padding:1em;background:gold">
	Si no tens usuari, <a href=contacte.php>contacta amb nosaltres</a> 
</div>

<script>
	function login_jugador() {
		var id=document.querySelector('#id_jugador').value;
		var pass=document.querySelector('#pass').value;
		window.location='controller/login_jugador.php?id='+id+'&pass='+pass;
	}
	function buscaEnter(event) {
		var tecla=event.which;
		if(tecla==13) login_jugador()
	}
</script>

<script>
function login() {
	var p=prompt('Contrasenya?')
	if(p) window.location='controller/login.php?pass='+p
}
</script>
<br><a href=# onclick=login()>Admin</a>
