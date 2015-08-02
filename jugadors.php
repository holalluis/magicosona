<?php include 'mysql.php'; ?>
<!doctype html>
<html>
<head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet type="text/css" href="estils.css" />
	<title>Lliga Osonenca de Modern - Jugadors</title>
</head>
<body><center>
<?php include 'header_sessio.php' ?>
<?php include 'menu.php' ?>

<!--LOGO-->
<h2 onclick="window.location.reload()" style="cursor:pointer">
Jugadors A-Z (<?php echo mysql_num_rows(mysql_query("SELECT 1 FROM jugadors")) ?>)</a>
</h2>

<table>
	<tr>
		<th colspan=2> Nom
		<th>Punts
		<th>Articles en venta
	<?php
		$sql="SELECT * FROM jugadors ORDER BY nom";
		$res=mysql_query($sql);
		$i=1;
		while($row=mysql_fetch_array($res))
		{
			$id=$row['id'];
			$nom=$row['nom'];
			echo "<tr>
				<td>$i
				<td><a href='jugador.php?id=$id'>$nom";
			//punts
			$sql="SELECT punts FROM resultats WHERE id_jugador=$id";
			$ress=mysql_query($sql) or die('error');
			$punts=0;
			while($roww=mysql_fetch_array($ress))
			{
				$punts+=$roww['punts'];
			}
			echo "<td align=center>$punts";
			//articles en venta
			echo "<td align=center>".mysql_num_rows(mysql_query("SELECT 1 FROM ofertes WHERE id_jugador=$id"));
			$i++;
		}
	?>
</table>
