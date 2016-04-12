<?php
	// ESDEVENIMENT.PHP: INFORMACIÓ I RESULTATS D'UN TORNEIG CONCRET
	$id=$_GET['id'];
	include 'mysql.php';
	$sql="SELECT * FROM esdeveniments WHERE id=$id";
	$res=mysql_query($sql);
	$row=mysql_fetch_assoc($res);
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet type="text/css" href="estils.css" />
	<style> #taula th,#taula td {border-left:none;border-right:none} </style>
	<script>
		function esborrar()
		{
			if(confirm("S'esborrarà tot l'esdeveniment. Continuar?"))
				window.location="controller/esborraEsdeveniment.php?id=<?php echo $id ?>"
		}
		function init()
		{
			//ressalta el top8
			var tops=document.querySelectorAll('td.top');
			for(var i=0; i<8; tops[i++].style.backgroundColor='gold'){}
		}
	</script>
</head>
<body onload=init()><center>
<?php include 'menu.php' ?>

<!-- RESULTATS D'ESDEVENIMENTS -->
<div style="padding:0.5em;background-color:#ccc">
Torneigs: 
<?php
	$sql="SELECT * FROM esdeveniments ORDER BY data ASC";
	$res=mysql_query($sql);
	while($roww=mysql_fetch_assoc($res))
		echo "<a href=esdeveniment.php?id=".$roww['id'].">".$roww['nom']."</a> | ";
?>
</div>

<?php
	//calcula el nombre de persones del torneig
	$res=mysql_query("SELECT 1 FROM resultats WHERE id_esdeveniment=$id AND punts>0");
	$nombreAssistents=mysql_num_rows($res);
?>

<h3>
<?php echo "Torneig ".$row['nom']." - <span style=color:#666>$nombreAssistents jugadors</span> - ".$row['data'] ?>
</h3>

<table cellpadding=3 id=taula>
	<tr><th>#<th>Jugador<th>Punts<th>Deck
	<?php
		$sql="	
			SELECT 
				jugadors.nom AS jugador,
				jugadors.id AS id_jugador,
				resultats.baralla AS id_baralla,
				resultats.punts AS punts,
				resultats.id AS resultat,
				resultats.llista AS llista
			FROM 
				jugadors,resultats
			WHERE 
				resultats.id_esdeveniment=$id AND
				resultats.id_jugador=jugadors.id
			ORDER BY punts DESC";
		$res=mysql_query($sql);
		$i=1;
		while($row=mysql_fetch_assoc($res))
		{
			$resultat=$row['resultat'];
			$llista=$row['llista'];
			$jugador=$row['jugador'];
			$id_jugador=$row['id_jugador'];
			$id_baralla=$row['id_baralla'];
			$punts=$row['punts'];
			echo "<tr>";
			echo "<td class=top>$i";
			echo "<td><a href=jugador.php?id=$id_jugador>$jugador</a>";
			echo "<td>$punts";
			//consulta la baralla jugada (si n'hi ha)
			echo "<td>";
			if($id_baralla>0)
			{
				$roww=mysql_fetch_assoc(mysql_query("SELECT nom FROM baralles WHERE id=$id_baralla"));
				$baralla=$roww['nom'];
				if($llista=="")
					echo "<span onclick=window.location='llista.php?id=$resultat'>$baralla</span>";
				else
					echo "<a href=llista.php?id=$resultat>$baralla</a>";
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

