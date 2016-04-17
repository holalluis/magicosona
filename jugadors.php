<?php include 'mysql.php'; ?>
<!doctype html>
<html>
<head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet type="text/css" href="estils.css" />
	<style> #taula th,#taula td {border-left:none;border-right:none} </style>
	<title>Lliga Osonenca de Modern - Jugadors</title>
</head>
<body><center>
<?php include_once("analytics.php") ?>
<?php include 'menu.php' ?>

<!--LOGO-->
<h2 onclick="window.location.reload()" style="cursor:pointer">
Jugadors A-Z (<?php echo mysql_num_rows(mysql_query("SELECT 1 FROM jugadors")) ?>)</a>
</h2>

<!--jugadors-->
<table id=taula>
	<tr><th>Nom<th>Punts
	<?php
		$sql="SELECT * FROM jugadors ORDER BY nom";
		$res=mysql_query($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$id=$row['id'];
			$nom=$row['nom'];
			echo "<tr><td><a href='jugador.php?id=$id'>$nom";
			//punts
			$sql="SELECT punts FROM resultats WHERE id_jugador=$id";
			$ress=mysql_query($sql) or die('error');
			$punts=0;
			while($roww=mysql_fetch_assoc($ress))
				$punts+=$roww['punts'];
			echo "<td align=center>$punts";
		}
	?>
</table>
