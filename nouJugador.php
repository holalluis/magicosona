<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Nou Jugador</title>
</head>
<body onload=document.getElementsByName('nom')[0].focus()><center>
<a href=index.php>Pàgina principal</a>
<h1>Inserta nou jugador</h1>

<form action="controller/nouJugador.php" method=get>
<table cellpadding=5>
	<tr><td>Nom<td><input name=nom placeholder=Nom autocomplete=off required>
	<tr><td>DCI<td><input name=dci placeholder="nº DCI (opcional)" autocomplete=off>
	<tr><td><td><button type=submit>Guarda</button>
</table>
</form>
