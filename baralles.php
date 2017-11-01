<?php
	// PÀGINA PRINCIPAL
	include 'mysql.php';
?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Baralles</title>
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
<table cellpadding=5>
	<tr><th>Nº<th>Baralla<th>Esborra<th>Canvia nom
	<?php
		// Llista de baralles
		$sql="SELECT * FROM baralles ORDER BY nom";
		$res=$mysql->query($sql);
		$i=1;
		while($row=mysqli_fetch_assoc($res))
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
