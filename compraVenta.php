<?php include 'mysql.php' ?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
	<link rel=stylesheet href="estils.css">
	<title>Lliga Osonenca de Modern - Compra Venta</title>
	<script>
		function init()
		{
			document.getElementById('q').focus()
		}
		function infoVenta()
		{
			alert("És responsabilitat de cada jugador de contactar amb els altres jugadors per fer compra-venta de cartes. El Totoptero Team no ens fem responsables del preu ni la disponibilitat de les cartes que els jugadors llistin dins la web.")
		}
	</script>
	<style> table{display:inline-block;vertical-align:top} </style>
</head>
<body onload=init()><center>
<?php include'cover.php'?>
<?php include'menu.php'?>

<!--TITOL--><h2 onclick=window.location='compraVenta.php' style="cursor:pointer"> Compra-Venta de Cartes </h2>

PAGINA EN CONSTRUCCIO. S'ESTÀ FENT UN MODUL PER CONNECTAR AL MAGGICARDMARKET.

<!--busca cartes-->
<form style=margin:1em> 
	<input id=q placeholder="Busca cartes" type=search name=q> 
	<button>Busca</button> 
</form>

<table> <tr><th>Carta<th>Venedor<th>Quantitat<th>Foil<th>Preu</table>

<table id=venedors>
	<tr><th colspan=2>Venedors amb més cartes
	<tr><th>Nom<th>Articles en venta
</table>

