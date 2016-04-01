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
	</script>
	<style> table{display:inline-block;vertical-align:top} </style>
</head>
<body onload=init()><center>
<?php include'menu.php'?>

<!--TITOL--><h2 onclick=window.location='compraVenta.php' style="cursor:pointer"> Compra-Venta de Cartes </h2>

<table>
	<tr><th>Jugador<th>Cartes en venda
	<?php
		$sql="SELECT * FROM jugadors WHERE mkm!='' ";
		$result=mysql_query($sql) or die('error');
		while($row=mysql_fetch_assoc($result))
		{
			$nom=$row['nom'];
			$id=$row['id'];
			$mkm=$row['mkm'];
			echo "<tr>
				<td><a href=jugador.php?id=$id>$nom</a>
				<td><a href=album.php?id=$id>Cartes</a>
				";
		}
	?>
</table>
