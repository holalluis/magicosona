<?php
	// PÀGINA PRINCIPAL
	include 'mysql.php';

	$id = isset($_GET['id']) ? $_GET['id'] : false;

	if(!$id) die('baralla no triada');

	$nomBaralla = current(mysql_fetch_assoc(mysql_query("SELECT nom FROM baralles WHERE id=$id")));
?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Magic Osona - Baralla</title>
</head><body onload=init()><center>
<?php include_once("analytics.php") ?>
<?php include 'menu.php' ?>

<h2>Aparicions de <span style=color:#666><?php echo $nomBaralla?></span></h2>

<!--baralles del mateix tipus-->
<table cellpadding=5 style=max-width:100%>
	<tr><th>Llista<th>Jugador<th>Torneig<th>Punts
	<?php
		// Llista d'esdeveniments
		$sql="SELECT 
				*, resultats.id AS resultat, esdeveniments.nom AS esdeveniment, jugadors.nom AS jugador
			FROM 
				resultats,jugadors,esdeveniments 
			WHERE 
				baralla=$id AND 
				resultats.id_jugador=jugadors.id AND 
				resultats.id_esdeveniment=esdeveniments.id
			ORDER BY 
				id_esdeveniment DESC,
				punts DESC";
		$res=mysql_query($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$resultat = new stdClass;
			$resultat->id=$row['resultat'];
			$resultat->id_jugador=$row['id_jugador'];
			$resultat->jugador=$row['jugador'];
			$resultat->id_esdeveniment=$row['id_esdeveniment'];
			$resultat->esdeveniment=$row['esdeveniment'];
			$resultat->punts=$row['punts'];
			$resultat->llista=$row['llista'];
			$nom=$row['nom'];
			echo " <tr>";

			if($resultat->llista=="")
				echo "<td>$nomBaralla";
			else
				echo "<td><a href=llista.php?id=$resultat->id>$nomBaralla</a>";

			echo "
				<td><a href=jugador.php?id=$resultat->id_jugador>$resultat->jugador</a>
				<td><a href=esdeveniment.php?id=$resultat->id_esdeveniment>$resultat->esdeveniment</a>
				<td>$resultat->punts
			";
		}
	?>
</table>

