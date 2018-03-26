<!--navbar-->

<!--admin-->
<?php include 'menuAdmin.php'?>

<?php
	//Hola jugador
	if(isset($_COOKIE['jugador']))
	{ ?>
		<div id=holaJugador> Hola
			<?php
				$cookie_jugador=$_COOKIE['jugador'];
				$nom = current(mysqli_fetch_assoc($mysql->query("SELECT nom FROM jugadors WHERE id=$cookie_jugador")));
				echo "<a href=jugador.php?id=$cookie_jugador>$nom! &#128100;</a>";
			?>
		</div>
		<style>
			#holaJugador {
				background:gold;
				padding:0.3em;
			}
		</style>
	<?php }
?>

<style>
	#navbar {
		display:flex;
		flex-wrap:wrap;
		justify-content:center;
		background:linear-gradient(#eee,#ddd);
		border-bottom:none;
	}
	#navbar a {
		display:block;
		text-decoration:none;
		border:1px solid #ccc;
		border-top:none;
		border-bottom:1px solid #ddd;
		padding:0.5em;
		margin-right:-1px;
	}
	#navbar a:hover {
		background-color:#fefefe;
		border-bottom-color:#395693;
	}
</style>

<div id=navbar>
	<a index       href=index.php>Inici</a>
	<a torneigs    href=torneigs.php>Torneigs</a>
	<a jugadors    href=jugadors.php>Jugadors</a>
	<a compraVenta href=compraVenta.php>Market</a>
	<a bases       href=bases.php>Bases</a>
	<!--<a comptador   href=comptador>Comptador</a>-->
	<?php
		if(isset($_COOKIE['jugador'])) 
		{ ?>
			<a href='controller/logout.php'>Surt</a>
		<?php }
		else
		{ ?>
			<a login href='login.php'>Login</a>
		<?php }
	?>
</div>
