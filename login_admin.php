<?php include'mysql.php'?>
<!doctype html><html><head>
	<?php include'imports.php'?>
	<title>Login Admin</title>
	<style>
		#navbar [login]{
			background:#fefefe;
			border-bottom-color:#395693;
		} 
	</style>
</head><body><center>
<?php include'menu.php'?>

<p>
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
			?>
				<form action=controller/login.php method=post>
					<input name=pass type=password placeholder="Admin password">
					<button>Entra</button>
				</form>
				<p>
					Avís: no intentis entrar si no ets admin. Sóc bastant bo identificant trapelles :)
				</p>
			<?php
		}
	?>
</p>
