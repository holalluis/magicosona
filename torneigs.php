<?php include 'mysql.php'; ?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Magic Osona - Torneigs</title>
</head> <body><center>
<?php include_once("analytics.php") ?>
<?php include 'menu.php' ?>

<h2>Torneigs celebrats aquesta temporada</h2>

<div class=inline style=padding:2em>
	<button style=font-size:16px;padding:0.5em onclick="window.location='metagame.php'">Veure metagame</button>
</div>

<!--Torneigs-->
<table class=inline style="margin:0.5em 0 0.5em 0">
	<tr><th>Torneig<th>Jugadors<th>Data
	<?php
		$sql="SELECT * FROM esdeveniments ORDER BY data DESC";
		$res=mysql_query($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$id=$row['id'];
			$nom=$row['nom'];
			$data=$row['data'];
			$jugadors=current(mysql_fetch_assoc(mysql_query("SELECT COUNT(*) FROM resultats WHERE id_esdeveniment=$id")));
			echo "
				<tr>
					<td><a href=esdeveniment.php?id=$id>$nom</a>
					<td><a href=esdeveniment.php?id=$id>$jugadors</a>
					<td><a href=esdeveniment.php?id=$id>$data</a>
			";
		}
	?>
</table>
