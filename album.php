<?php
	//ENTRADA: id jugador
	//album visual de les cartes en venda del jugador id
	$jugador=new stdClass;
	$id=$_GET['id'];
	include 'mysql.php';
	$res=mysql_query("SELECT nom,mkm FROM jugadors WHERE id=$id");
	$row=mysql_fetch_assoc($res);
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

<!--TITOL--><h2>Magic Card Market - <?php echo $jugador->nom ?></h2>

<div>
	<?php 
		if($jugador->mkm=="")die('El jugador no té compte de magiccardmarket');
	?>
	<iframe style="width:95%;height:50em" src="https://www.magiccardmarket.eu/?mainPage=browseUserProducts&idCategory=1&idUser=<?php echo $jugador->mkm?>">
	</iframe>
</div>

