<?php
	//ENTRADA: id jugador
	//album visual de les cartes en venda del jugador id
	$jugador=new stdClass;
	$id=$_GET['id'];
	include 'mysql.php';
	$res=mysql_query("SELECT nom,mkm FROM jugadors WHERE id=$id");
	$row=mysql_fetch_array($res);
	$jugador->nom=$row['nom'];
	$jugador->mkm=$row['mkm'];
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet type="text/css" href="estils.css" />
	<title>Àlbum</title>
</head><body><center>
<?php include 'menu.php' ?>

<!--TITOL--><h2>Àlbum Visual - <?php echo $nomJugador ?></h2>

<div>
	<?php 
		if($jugador->mkm=="")die('No té usuari de mkm');

		include'mkm.php';
		$url="$api/user/$jugador->mkm";
		$url="$api/user/holalluis";
		$a=mkmapi($url);
		echo $a;
	?>
</div>

