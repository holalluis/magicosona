<?php 
	include 'mysql.php';
?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Nou torneig</title>
	<script>
		function desactivaCheckboxs(el)
		{
			//coleccio d'elements checkboxp pel primer del suis
			var coleccio = document.getElementsByClassName('checkbox_primer_suis')	

			//opcio que es posara a tots menys a "el"
			var disabl = el.checked ? true : false

			//posa a tots els elements la opcio triada
			for(var i=0;i<coleccio.length;i++)
				coleccio[i].disabled=disabl

			//disabled=false sempre a "el"
			el.disabled=false
		}
	</script>
</head>
<body><center>
<a href=index.php>Pàgina principal</a>
<h1>Nou Esdeveniment</h1>

<form action="controller/nouEsdeveniment.php" method=get>
	<table cellpadding=5>
		<tr><td>Nom<td><input required autocomplete=off name=nom placeholder="Nom Esdeveniment">
		<tr><td>Data<td><input type=date required autocomplete=off name=data placeholder="Data">
	</table>

	<br>

	<table cellpadding=5>
		<tr><th>Jugador<th>Punts Suís<th>Posició Torneig<th>Primer del suís
		<?php
			$sql="SELECT * FROM assistentsProximTorneig,jugadors WHERE jugadors.id=assistentsProximTorneig.id_jugador ORDER BY nom ";	
			$res=$mysql->query($sql);
			while($row=mysqli_fetch_assoc($res))
			{
				echo "<tr>";
				echo "<td>".$row['nom'];
				echo "<td><input autocomplete=off placeholder='Punts' size=3 name=punts_jugador_".$row['id'].">";
				echo "<td> <select name=posicio_jugador_".$row['id'].">";
				echo "<option value=1>1r";
				echo "<option value=2>2n";
				echo "<option value=3>3r-4rt";
				echo "<option value=4>5è-8è";
				echo "<option value=5 selected>9è o menys";
				echo "</select>";
				echo "<td><input 
					type=checkbox 
					onchange=desactivaCheckboxs(this) 
					class=checkbox_primer_suis
					name=is_primer_suis_jugador_".$row['id'].">";
			}
		?>
	</table>
	<br>
	<button type=submit>Guardar</button>
</form>
