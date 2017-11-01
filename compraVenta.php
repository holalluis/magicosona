<?php include 'mysql.php' ?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Magiccardmarket</title>
	<style>
		#navbar [compraVenta]{
			background:#fefefe;
			border-bottom-color:#395693;
		} 
	</style>
</head>
<body><center>
<?php include'menu.php'?>
<!--TITOL--><h2>MagicCardMarket</h2>

<!--descr-->
<div style="margin:1em">
	Aquí trobaràs les cartes en venda dels jugadors. 
	<br>
	<small>
		Si vols aparèixer aquí, 
		escriu el teu nº d'usuari de MKM <b>(número de 5-7 xifres)</b>
		a la teva pàgina de perfil
	</small>
</div>

<!--columna buscar-->
<?php
/*
<div>
	<!--busca-->
	<div style="border:1px solid #ccc;padding:0.5em;border-radius:1em;margin:0 0.5em 0 0.5em">
		<form action=buscaCarta.php method=GET style=text-align:left>
			Busca una carta:
			<input name=carta type=search placeholder="Cryptic Command">
		</form>
	</div>

	<div id=filtres style="text-align:left;border:1px solid #ccc;padding:0.5em;border-radius:1em;margin:0.5em">
		<style>#filtres button{margin:0.5em}</style>
		<div>Explora cartes de tots els jugadors:</div>
		<!--veure mítiques--> <div><button onclick="window.location='buscaCarta.php?carta=&rarity=17'">Veure mítiques</button></div>
		<!--veure rares-->    <div><button onclick="window.location='buscaCarta.php?carta=&rarity=18'">Veure rares</button></div>
		<!--veure timeshift--><div><button onclick="window.location='buscaCarta.php?carta=&rarity=20'">Veure time shifted</button></div>
		<!--veure tokens-->   <div><button onclick="window.location='buscaCarta.php?carta=&rarity=24'">Veure tokens</button></div>
	</div>
</div>
*/
?>

<!--jugadors-->
<div>
	<table style=margin:auto>
		<tr><th>Jugador<th>Link a Magiccardmarket
		<?php
			$sql="SELECT * FROM jugadors WHERE mkm!='' ORDER BY nom ASC";
			$result=$mysql->query($sql) or die('error');
			while($row=mysqli_fetch_assoc($result))
			{
				$nom=$row['nom'];
				$id=$row['id'];
				$mkm=$row['mkm'];
				$url_mkm="https://www.magiccardmarket.eu/?mainPage=browseUserProducts&idCategory=1&idUser=$mkm";
				echo "<tr>
					<td> <a href='jugador.php?id=$id'>$nom</a>
					<td> <a target=_blank href='$url_mkm'>Veure Cartes (id: $mkm)</a>
				";
			}
		?>
	</table>
</div>

<?php include 'footer.php' ?>
