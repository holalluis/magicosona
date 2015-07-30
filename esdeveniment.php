<?php
	// ESDEVENIMENT.PHP: INFORMACIÓ I RESULTATS D'UN TORNEIG CONCRET
	$id=$_GET['id'];
	include 'mysql.php';
	$sql="SELECT * FROM esdeveniments WHERE id=$id";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet type="text/css" href="estils.css" />
	<script>
		function esborrar()
		{
			if(confirm("S'esborrarà tot l'esdeveniment. Continuar?"))
				window.location="controller/esborraEsdeveniment.php?id=<?php echo $id ?>"
		}
		function init()
		{
			//ressalta el top8
			for(var i=0;i<8;i++)
				document.getElementsByClassName('top')[i].style.backgroundColor='gold'
		}
	</script>
</head>
<body onload=init()><center>
<?php include 'header_sessio.php' ?>
<?php include 'menu.php' ?>

<!-- RESULTATS D'ESDEVENIMENTS -->
<div style="padding:0.5em;background-color:#ccc">
Resultats: 
<?php
	$sql="SELECT * FROM esdeveniments";
	$res=mysql_query($sql);
	while($roww=mysql_fetch_array($res))
		echo "<a href=esdeveniment.php?id=".$roww['id'].">".$roww['nom']."</a> | ";
?>
</div>

<?php
	//calcula el nombre de persones del torneig
	$res=mysql_query("SELECT 1 FROM resultats WHERE id_esdeveniment=$id AND punts>0");
	$nombreAssistents=mysql_num_rows($res);
?>

<h2>
Resultats del Torneig "<?php echo $row['nom']."\" ($nombreAssistents jugadors)" ?>
 <?php echo $row['data'] ?>
</h2>

<table cellpadding=3>
	<tr><th>Posició<th>Jugador<th>Punts<th>Deck
	<?php
		$sql="	SELECT 
				jugadors.nom AS jugador,
				jugadors.id AS id_jugador,
				resultats.baralla AS id_baralla,
				resultats.punts AS punts
			FROM 
				jugadors,resultats
			WHERE 
				resultats.id_esdeveniment=$id AND
				resultats.id_jugador=jugadors.id
			ORDER BY punts DESC";
		$res=mysql_query($sql);
		$i=1;
		while($row=mysql_fetch_array($res))
		{
			$jugador=$row['jugador'];
			$id_jugador=$row['id_jugador'];
			$id_baralla=$row['id_baralla'];
			$punts=$row['punts'];
			echo "<tr>";
			echo "<td>$i";
			echo "<td><a href=jugador.php?id=$id_jugador>$jugador</a>";
			echo "<td>$punts";
			//consulta la baralla jugada (si n'hi ha)
			echo "<td>";
			if($id_baralla>0)
			{
				$roww=mysql_fetch_array(mysql_query("SELECT nom FROM baralles WHERE id=$id_baralla"));
				$baralla=$roww['nom'];
				echo "$baralla";
			}
			$i++;
		}
	?>
</table>
<br>
<?php
	if(isset($_COOKIE['admin']))
		echo "<button onclick=esborrar()>Esborrar Esdeveniment</button>";
?>

