<?php include'mysql.php'?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Recuperar contrasenya</title>
	<style>
		#link {
			display:block;
			font-size:22px;
			padding:0.5em;
			margin:0.5em;
		}
	</style>
</head><body><center>
<!--menus--><?php include'menu.php'?>
<h2>Recuperar contrasenya</h2>

<div style=padding:0.5em>
	Per reiniciar la teva contrasenya contacta en Lluís al Whatsapp a través d'aquest link:
</div>

<div>
	<a id=link target=_blank href="https://api.whatsapp.com/send?phone=34677626363">Whatsapp</a>
</div>

<?php include 'footer.php' ?>
