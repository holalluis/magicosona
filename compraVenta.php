<?php include 'mysql.php' ?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Lliga Osonenca de Modern - Compra Venta</title>
</head>
<body><center>
<?php include'menu.php'?>
<!--TITOL--><h2>MagicCardMarket</h2>

<!--descr-->
<div style="max-width:70%;margin:1em">
	Aquí trobaràs les cartes en venda dels jugadors. 
	<br>
	Si vols aparèixer aquí posa el teu nº d'usuari de MKM (id de 5 dígits) a la teva pàgina de perfil!
</div>

<!--columna buscar-->
<div style=width:49%>
	<!--busca-->
	<div style="border:1px solid #ccc;padding:0.5em;border-radius:1em;margin:0 0.5em 0 0.5em">
		<form action=buscaCarta.php method=GET style=text-align:left>
			Busca una carta:
			<input name=carta type=search placeholder="Cryptic Command" style="width:50%">
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

<!--jugadors-->
<div>
	<table>
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
					<td> <a target=_blank href='https://www.magiccardmarket.eu/?mainPage=browseUserProducts&idCategory=1&idUser=$mkm'>Veure MKM</a>
				";
			}
		?>
	</table>
</div>

<?php include 'footer.php' ?>
