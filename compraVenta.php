<?php include 'mysql.php' ?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
	<link rel=stylesheet href="estils.css">
	<style> #taula th,#taula td {border-left:none;border-right:none} </style>
	<title>Lliga Osonenca de Modern - Compra Venta</title>
	<style> table{display:inline-block;vertical-align:top} </style>
</head>
<body><center>
<?php include_once("analytics.php") ?>
<?php include'menu.php'?>
<!--TITOL--><h2 onclick=window.location='compraVenta.php' style="cursor:pointer"> MagicCardMarket </h2>

<!--descr--><h4 style=margin:0.5em>Aquí pots trobar les cartes en venda dels jugadors. Si vols ser visible, només has de dir el teu nom d'usuari de MKM a en Lluís</h4>

<!--busca-->
<div class=inline style="border:1px solid #ccc;padding:0.5em;border-radius:1em;margin:0.5em">
	<form action=buscaCarta.php method=GET>
		Busca una carta:
		<input name=carta type=search placeholder="Cryptic Command">
	</form>
</div>

<table id=taula class=inline>
	<tr><th>Jugador<th>Cartes en venda
	<?php
		$sql="SELECT * FROM jugadors WHERE mkm!='' ORDER BY nom ASC";
		$result=mysql_query($sql) or die('error');
		while($row=mysql_fetch_assoc($result))
		{
			$nom=$row['nom'];
			$id=$row['id'];
			$mkm=$row['mkm'];
			echo "<tr>
				<td> <a href=jugador.php?id=$id>$nom</a>
				<td> <a target=_blank href='https://www.magiccardmarket.eu/?mainPage=browseUserProducts&idCategory=1&idUser=$mkm'>Cartes disponibles</a>
			";
		}
	?>
</table>
