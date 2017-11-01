<?php 
	include 'mysql.php'; 
	include 'dataProximTorneig.php';
?>
<!doctype html><html><head><?php include'imports.php'?>
	<title>Login</title>
	<style>
		#navbar [login]{
			background:#fefefe;
			border-bottom-color:#395693;
		} 
	</style>
</head><body><center>
<?php include'menu.php'?>

<div id=form style="margin:0;background-color:#395693;color:white;padding:3em 0.5em">
	<style>
		#form input {max-width:40%}
	</style>
	<?php
		if(isset($_COOKIE['admin'])) { 
			?>
			Sessió iniciada com a ADMINISTRADOR
			<?php 
		}
		else if(isset($_COOKIE['jugador'])) {
			$sql="SELECT nom FROM jugadors WHERE id=".$_COOKIE['jugador'];
			$ress=$mysql->query($sql) or die('error');
			$roww=mysqli_fetch_assoc($ress);
			$nom=$roww['nom'];
			echo "Sessió iniciada com a 
				<a style=color:white href=jugador.php?id=".$_COOKIE['jugador'].">$nom</a>";
			echo " <button onclick=window.location='controller/logout.php'>Finalitza sessió</button>";
		} 
		else {
			echo "<small>Selecciona el teu nom i escriu la contrasenya</small><br><br>";
			echo "<select id=id_jugador>";
			$sql="SELECT * FROM jugadors ORDER BY nom ASC";
			$ress=$mysql->query($sql) or die('error');
			while($roww=mysqli_fetch_assoc($ress)) {
				$nom=$roww['nom'];
				$idd=$roww['id'];
				echo "<option value=$idd>$nom";
			}
			echo "</select>";

			echo " 
				<input id=pass type=password maxlength=20 placeholder=Contrasenya onkeydown=buscaEnter(event)>
				<button onclick=login_jugador()>ok</button>
				<p>
					<p>
						<a href=recuperar.php style=color:white>No recordo la contrasenya</a>
					<p>
						<a href=contacte.php style=color:white>Vull crear un perfil</a>
					</p>
				</p>
			";
		}
	?>
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
<br><a href=login_admin.php>Admin</a>
