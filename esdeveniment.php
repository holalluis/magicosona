<?php
	// ESDEVENIMENT.PHP: INFORMACIÓ I RESULTATS D'UN TORNEIG CONCRET
	$id=$_GET['id'];
	include 'mysql.php';
	$sql="SELECT * FROM esdeveniments WHERE id=$id";
	$res=mysql_query($sql);
	$row=mysql_fetch_assoc($res);
?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Torneig</title>
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
			for(var i=0; i<8; i++)
			{
				try
				{
					tops[i].style.backgroundColor='gold';
				}
				catch(e)
				{
					break;
				}
			}
		}
	</script>
</head>
<body onload=init()><center>
<?php include_once("analytics.php") ?>
<?php include 'menu.php' ?>

<!--TOTS ELS ESDEVENIMENTS -->
<div style="padding:0.5em;background-color:gold;box-shadow: 0 5px 5px -5px rgba(0,0,0,0.3);">
	<span style=color:#666>Torneigs</span> &emsp;
	<?php
		$sql="SELECT * FROM esdeveniments ORDER BY data ASC";
		$res=mysql_query($sql);
		while($roww=mysql_fetch_assoc($res))
		{
			$idd=$roww['id'];
			$nomm=$roww['nom'];
			if($nomm==$row['nom'])
				echo $nomm;
			else
				echo "<a href=esdeveniment.php?id=$idd>$nomm</a>";
			echo "&emsp;";
		}
	?>
</div>

<?php
	//calcula el nombre de persones del torneig
	$res=mysql_query("SELECT 1 FROM resultats WHERE id_esdeveniment=$id AND punts>0");
	$nombreAssistents=mysql_num_rows($res);
?>

<h3>
<?php echo "<a href=torneigs.php>Torneigs</a> &rsaquo; ".$row['nom']." · <span style=color:#666>$nombreAssistents jugadors</span> · ".$row['data'] ?>
</h3>

<table>
	<tr><th>#<th>Baralla<th>Jugador<th>Punts
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
			echo "<tr> 
					<td class=top>$i
					<td>
			";

			if($id_baralla>0)
			{
				$roww=mysql_fetch_assoc(mysql_query("SELECT nom FROM baralles WHERE id=$id_baralla"));
				$baralla=$roww['nom'];
				if($llista=="")
					echo "<span title='Llista no disponible' style=color:#aaa onclick=window.location='llista.php?id=$resultat'>$baralla</span>";
				else
					echo "<a href=llista.php?id=$resultat>$baralla</a>";
			}
			else echo "N/A";

			echo "<td><a href=jugador.php?id=$id_jugador>$jugador</a>";
			echo "<td>$punts";

			$i++;
		}
	?>
</table>
<br>
<?php
	if(isset($_COOKIE['admin']))
		echo "<button onclick=esborrar()>Esborrar Esdeveniment</button>";
?>

