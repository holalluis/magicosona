<?php
	// ESDEVENIMENT.PHP: INFORMACIÓ I RESULTATS D'UN TORNEIG CONCRET
	$id=$_GET['id'];
	include 'mysql.php';
	$sql="SELECT * FROM esdeveniments WHERE id=$id";
	$res=$mysql->query($sql);
	$row=mysqli_fetch_assoc($res);
	$nom=$row['nom'];
	$nomTorneig=$row['nom'];
?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Torneig <?php echo $nom?></title>
	<script>
		function esborrar() {
			if(confirm("S'esborrarà tot l'esdeveniment. Continuar?"))
				window.location="controller/esborraEsdeveniment.php?id=<?php echo $id ?>"
		}
	</script>
	<style>
		table#resultats tr:nth-child(-n+9) td:first-child {
			background:gold;
		}
		h3 {margin-bottom:0.5em}
	</style>
</head>
<body><center>
<?php include 'menu.php' ?>

<!--TOTS ELS ESDEVENIMENTS -->
<div style="padding:0.5em;background-color:gold;box-shadow: 0 5px 5px -5px rgba(0,0,0,0.3);">
	<?php
		$sql="SELECT * FROM esdeveniments ORDER BY data ASC";
		$res=$mysql->query($sql);
		while($roww=mysqli_fetch_assoc($res)) {
			$idd=$roww['id'];
			$nomm=$roww['nom'];
			if($nomm==$row['nom'])
				echo "<span style='margin:0.5em;padding:0.3em;border-radius:0.5em;background:white;'>$nomm</span>";
			else
				echo "<a style='margin:0.5em;padding:0.3em' href=esdeveniment.php?id=$idd>$nomm</a>";
		}
	?>
</div>

<?php
	//calcula el nombre de persones del torneig
	$res=$mysql->query("SELECT 1 FROM resultats WHERE id_esdeveniment=$id AND punts>0");
	$nombreAssistents=mysqli_num_rows($res);
?>

<h3>
<?php echo "Torneig ".$row['nom']." · <span style=color:#666>$nombreAssistents jugadors</span> · ".date("d/m/Y",strtotime($row['data'])) ?>
</h3>

<!--resultats-->
<div class=flex>
	<!--botons veure imatges-->
	<div style="text-align:left;margin:0 5px;max-width:29%" id=botons_veure>
		<style>
			#botons_veure button {
				padding:1em 1em;
				margin-bottom:0.5em;
				display:block;
				font-size:12px;
			}
		</style>
		<?php
			$nom=$nomTorneig;
			if(file_exists("img/torneigs/elim$nom.png"))
			{ 
				echo "<button onclick=window.location=('img/torneigs/elim$nom.png')>Veure eliminatòria TOP 8</button>";
			}
			if(file_exists("img/torneigs/$nom.jpg"))
			{ ?>
				<button onclick="window.location=('img/torneigs/<?php echo $nom ?>.jpg')">Veure cartell i premis</button>
				<?php
			}
		?>
	</div>

	<!--punts-->
	<div style="max-width:70%">
		<table id=resultats>
			<tr><th><th>Baralla<th>Jugador<th>Punts
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
				$res=$mysql->query($sql);
				$i=1;
				while($row=mysqli_fetch_assoc($res))
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
						$roww=mysqli_fetch_assoc($mysql->query("SELECT nom FROM baralles WHERE id=$id_baralla"));
						$baralla=$roww['nom'];
						$color_link = ($llista=="") ? "style=color:#666" : "";
						echo "<a href=llista.php?id=$resultat $color_link>$baralla</a>";
					}
					else echo "<span style=color:#aaa;font-family:monospace>~no disponible</span>";

					echo "<td><a href=jugador.php?id=$id_jugador>$jugador</a>";
					echo "<td>$punts";

					$i++;
				}
			?>
		</table>
	</div>
</div>

<br><?php
	if(isset($_COOKIE['admin'])){
		echo "<button onclick=esborrar() style=margin:'2em 0'>Esborrar Esdeveniment</button>";
	}
?>

<?php include 'footer.php' ?>
