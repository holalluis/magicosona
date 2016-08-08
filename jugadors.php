<?php include 'mysql.php'; ?>
<!doctype html> <html> <head>
	<?php include 'imports.php' ?>
	<title>Lliga Osonenca de Modern - Jugadors</title>
</head>
<body><center>
<?php include 'menu.php' ?>

<!--LOGO-->
<h2>
Tots els jugadors A-Z (<?php echo mysql_num_rows(mysql_query("SELECT 1 FROM jugadors")) ?>)</a>
</h2>

<!--jugadors-->
<table style=margin-top:0.5em> 
	<?php
		$sql="SELECT * FROM jugadors ORDER BY nom";
		$res=mysql_query($sql);
		$i=1;
		while($row=mysql_fetch_assoc($res))
		{
			$id=$row['id'];
			$nom=$row['nom'];
			$dci=$row['dci'] ? $row['dci'] : "";

			echo "<tr>
				<td>$i<td><a href='jugador.php?id=$id'>$nom<td>$dci";
			$i++;
		}
	?>
</table>
