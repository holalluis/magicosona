<?php include 'mysql.php'; ?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Magic Osona - Torneigs</title>
</head> <body><center>
<?php include 'menu.php' ?>
<h2>Torneigs celebrats aquesta temporada</h2>

<div style=margin-top:0.5em>

<!--Torneigs-->
<div class=inline style="max-width:70%;">
	<table>
		<tr><th>Torneig<th>Jugadors<th>Data
		<?php
			$sql="SELECT * FROM esdeveniments ORDER BY data DESC";
			$res=mysql_query($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$id=$row['id'];
				$nom=$row['nom'];
				$data=$row['data'];
				$timeAgo=timeAgo($data);
				$data_for=date("d/m/Y",strtotime($data));
				$jugadors=current(mysql_fetch_assoc(mysql_query("SELECT COUNT(*) FROM resultats WHERE id_esdeveniment=$id")));
				echo "
					<tr>
						<td><a href=esdeveniment.php?id=$id>$nom</a>
						<td><a href=esdeveniment.php?id=$id>$jugadors</a>
						<td><a href=esdeveniment.php?id=$id>$data_for</a> <span style=font-size:12px>($timeAgo)</span>
				";
			}
		?>
	</table>
</div>

<!--veure meta-->
<div class=inline style="max-width:28%;text-align:left;">
	<button style="padding:1.5em 0.5em" onclick="window.location='metagame.php'">Veure metagame</button>
</div>

</div>

