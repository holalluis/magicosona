<?php
	// PÀGINA PRINCIPAL
	include 'mysql.php';
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet type="text/css" href="estils.css" />
	<title>Lliga Osonenca de Modern 2015 - Baralles</title>
	<script>
		function esborra(id)
		{
			window.location="controller/esborraBaralla.php?id="+id
		}
		function init()
		{
			//focus a nova baralla
			document.getElementsByName('nom')[0].focus()
		}
	</script>
</head><body onload=init()><center>
<?php include_once("analytics.php") ?>

<!-- MENU -->
<div> <a href=index.php>Pàgina principal</a> </div>

<!-- TITOL -->
<h2>Baralles</h2>

<!-- check admin -->
<?php
	if(!isset($_COOKIE['admin']))
		die('no ets admin');
?>

<!-- nova baralla -->
<div>
<form action="controller/novaBaralla.php" method=GET>
	<table cellpadding=5>
	<tr>
		<td>Nova Baralla
		<td><input name=nom placeholder=Nom autocomplete=off required>
		<td><button type=submit>Guarda</button>
	</table>
</form>
</div>

<!-- Baralles -->
<div>
<table cellpadding=5 id=taula>
	<tr><th>Nº<th>Baralla<th>Esborra<th>Canvia nom
	<?php
		// Llista de baralles
		$sql="SELECT * FROM baralles ORDER BY nom";
		$res=mysql_query($sql);
		$i=1;
		while($row=mysql_fetch_assoc($res))
		{
			$id=$row['id'];
			$nom=$row['nom'];
			echo "<tr><td>$i<td>$nom";

			//esborrar baralla de la base de dades
			echo "<td><button onclick=esborra($id)>Esborra</button>";

			//formulari per canviar el nom de la baralla
			echo "<td><form action='controller/canviaNomBaralla.php' method=GET>";
			echo "<input placeholder='Nou Nom' name=nom>";
			echo "<input name=id value=$id type=hidden>";
			echo "<button type=submit>Ok</button>";
			echo "</form>";

			$i++;
		}
	?>
</table>
</div>

<!-- FOOTER -->
<div style=font-size:13px;margin:2px;padding:1em> Organitzat per Totoptero Team. Web creada per Lluís Bosch. Tots els drets reservats.  </div>
