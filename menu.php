<!--navbar-->

<?php include 'menuAdmin.php'?>

<?php
	//Hola jugador
	if(isset($_COOKIE['jugador']))
	{ ?>
			<div id=holaJugador> Hola
				<?php
					$cookie_jugador=$_COOKIE['jugador'];
					$nom = current(mysql_fetch_assoc(mysql_query("SELECT nom FROM jugadors WHERE id=$cookie_jugador")));
					echo "<a href=jugador.php?id=$cookie_jugador>$nom! &#128100;</a>";
				?>
			</div>
			<style>
				#holaJugador
				{
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
		box-shadow:0 1px 2px rgba(0,0,0,0.2);
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
	<a href=index.php>Inici</a>
	<a href=bases.php>Bases</a>
	<a href=torneigs.php>Torneigs</a>
	<a href=jugadors.php>Jugadors</a>
	<a href=compraVenta.php>Market</a>
	<a href=contacte.php>Contacte</a>
	<?php
		if(isset($_COOKIE['jugador'])||isset($_COOKIE['admin'])) 
		{ ?>
			<a href='controller/logout.php'>Surt</a>
		<?php }
		else
		{ ?>
			<a href='login.php'>Login</a>
		<?php }
	?>
</div>

