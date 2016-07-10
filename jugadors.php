<?php include 'mysql.php'; ?>
<!doctype html> <html> <head>
	<?php include 'imports.php' ?>
	<title>Lliga Osonenca de Modern - Jugadors</title>
</head>
<body><center>
<?php include_once("analytics.php") ?>
<?php include 'menu.php' ?>

<!--LOGO-->
<h2 onclick="window.location.reload()" style="cursor:pointer">
Tots els jugadors A-Z (<?php echo mysql_num_rows(mysql_query("SELECT 1 FROM jugadors")) ?>)</a>
</h2>

<!--jugadors-->
<table> 
	<tr><th><th>Nom<th>Punts
	<?php
		$sql="SELECT * FROM jugadors ORDER BY nom";
		$res=mysql_query($sql);
		$i=1;
		while($row=mysql_fetch_assoc($res))
		{
			$id=$row['id'];
			$nom=$row['nom'];
			echo "<tr><td>$i<td><a href='jugador.php?id=$id'>$nom";
			//punts
			$sql="SELECT punts FROM resultats WHERE id_jugador=$id";
			$ress=mysql_query($sql) or die('error');
			$punts=0;
			while($roww=mysql_fetch_assoc($ress))
				$punts+=$roww['punts'];

			$color = $punts==0 ? "#ccc" : "";
			echo "<td style='text-align:right;color:$color'>$punts";

			$i++;
		}
	?>
</table>
