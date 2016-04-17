<!doctype html>
<html>
<head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet type="text/css" href="estils.css" />
	<title>Nou Jugador</title>
</head>
<body onload=document.getElementsByName('nom')[0].focus()><center>
<?php include_once("analytics.php") ?>
<a href=index.php>Pàgina principal</a>
<h1>Inserta nou jugador</h1>

<form action="controller/nouJugador.php" method=get>
	<table cellpadding=5>
	<tr><td>Nom<td><input name=nom placeholder=Nom autocomplete=off required>
	<tr><td><td><button type=submit>Guarda</button>
	</table>
</form>
