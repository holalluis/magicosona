<?php 
	include 'mysql.php'; 
	include 'dataProximTorneig.php';
?>
<!doctype html>
<html>
<head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet type="text/css" href="estils.css" />
	<style>
		#taula th,#taula td {border-left:none;border-right:none}
	</style>
	<title>Magic Osona - Torneigs</title>
</head>
<body><center>
<?php include 'menu.php' ?>
<!-- PROXIM ESDEVENIMENT -->
<div style="padding:0.5em;background-color:gold">
	<?php 
		//compta el numero de jugadors apuntats
		$assistents=mysql_num_rows(mysql_query("SELECT * FROM assistentsProximTorneig"));
		echo "
			<b>Pròxim torneig: </b> $dataProximTorneig
			<button onclick=window.location='assistents.php'>Veure inscrits ($assistents)</button>";
	?>
</div> 

<h2>Torneigs celebrats aquesta temporada</h2>

<!--Torneigs-->
<table style="margin:0.5em 0 0.5em 0" id=taula>
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
					<td>$jugadors
					<td>$data
			";
		}
	?>
</table>
