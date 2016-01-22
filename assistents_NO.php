<?php
	//Pàgina per mostrar una llista de jugadors NO apuntats al pròxim torneig

	include 'mysql.php';
	include 'dataProximTorneig.php';

	//compta jugadors de la lliga
	$sql="SELECT 1 FROM jugadors";
	$result=mysql_query($sql) or die('error');
	$total=mysql_num_rows($result);

	//request
	$sql="SELECT * FROM jugadors 
		WHERE NOT EXISTS (SELECT 1 FROM assistentsProximTorneig WHERE assistentsProximTorneig.id_jugador = jugadors.id)
		ORDER BY nom ASC";
	$result=mysql_query($sql) or die('error');
	$n=mysql_num_rows($result);
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet type="text/css" href="estils.css" />
	<title>NO inscrits al Pròxim Torneig</title>
	<?php include 'compteEnrere.php' ?>
	<script>
		function nouAssistent()
		{
			var id_jugador = document.getElementById('id_assistent').value;
			window.location='nouAssistent.php?id_jugador='+id_jugador
		}
		function eliminaAssistent(id)
		{
			window.location='controller/eliminaAssistent.php?id_jugador='+id
		}
	</script>
</head>
<body><center>

<div id=menu style=padding:0.5em>
	<a href='index.php'>Pàgina principal</a>
	|
	<a href='assistents.php'>Jugadors inscrits</a>
	|
	Jugadors NO inscrits
</div>

<h2>Jugadors no inscrits al pròxim torneig</h2>
<h4>
	Hi ha <?php echo $n."/".$total ?> jugadors NO inscrits.
	<b>Inscripcions</b>: Whatsapp (grup "Magic Osona") o <a href=mailto:holalluis@gmail.com>holalluis@gmail.com</a>
</h4>

<!-- PROXIM ESDEVENIMENT -->
<div style="padding:0.5em;background-color:gold">
	<?php echo "<b> Pròxim torneig ($nomProximTorneig):</b> $dataProximTorneig "; ?>
</div> 

<?php include 'menuAdmin.php'; ?>

<table cellpadding=1 id=taula>
	<?php
		$i=1;
		while($row=mysql_fetch_assoc($result))
		{
			$nom=$row['nom'];
			$id=$row['id'];
			echo "<tr>
				<td>$i
				<td><a href=jugador.php?id=$id>$nom</a>";
			$i++;
		}
	?>
</table>
