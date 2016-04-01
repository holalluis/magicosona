<?php
	include 'mysql.php';

	$id=$_GET['id'];
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet href="estils.css">
	<title>Pàgina de perfil</title>
	<script>
		function esborrar()
		{
			if(confirm("S'esborrarà el jugador i tots els seus resultats. Continuar?"))
				window.location="controller/esborraJugador.php?id=<?php echo $id ?>"
		}
		function setejaBaralla(id_resultat)
		{
			var baralla=document.getElementById('baralla_'+id_resultat).value
			var url="controller/setejaBaralla.php?id="+id_resultat+"&baralla="+encodeURI(baralla)
			window.location=url;
		}
	</script>
</head><body><center>
<?php include 'menu.php' ?>
<?php
	$sql="SELECT * FROM jugadors WHERE id=$id";
	$res=mysql_query($sql);
	$row=mysql_fetch_assoc($res);
?>

<!--TITOL-->
<h2><?php echo $row['nom'] ?></h2>

<?php
	//avis de sessio no iniciada
	if(!isset($_COOKIE['jugador']))
	{
		echo "<div style='max-width:50%;font-size:11px;margin-bottom:1em'>
			<form action=controller/login_jugador.php method=get>
				<input name=pass type=password placeholder=Contrasenya size=12 maxlength=10> 
				<input name=id value=$id hidden>
				 <button>Inicia Sessió</button>
				(Per saber la teva contrasenya contacta amb en Lluís pel Whatsapp)
			</form>
		</div>";
	}
?>

<!--LLISTA DE CARTES EN VENTA-->
<?php
	echo "<div style=margin:1em>";
	if($row['mkm']!="")
	{ 
		?>
			<button style="background-color:#af0;padding:1em"
				onclick="window.location='album.php?id=<?php echo $id ?>'"
				>Veure cartes en venda
			</button>
		<?php	
	}
	else
	{
		echo "No té usuari de Magiccardmarket associat";
	}
	echo "</div>";
?>

<!--PUNTS DEL JUGADOR A CADA TORNEIG-->
<table cellpadding=5>
	<tr><th>Torneig<th>Punts<th>Baralla
	<?php
		$punts_totals=0;
		$sql="SELECT * FROM esdeveniments ORDER BY data ASC";
		$res=mysql_query($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$esd=$row['id'];
			$sql="SELECT * FROM resultats WHERE id_esdeveniment=$esd AND id_jugador=$id";
			$ress=mysql_query($sql);
			$roww=mysql_fetch_assoc($ress);
			$punts=$roww['punts'];
			$punts_totals+=$punts;
			if($punts=='')
				$punts=0;

			//Baralla utilitzada al torneig
			$baralla=$roww['baralla'];

			if($punts!=0)
			{
				echo "<tr><td align=center><a href=esdeveniment.php?id=".$row['id'].">".$row['nom']."</a>";
				echo "<td align=center>$punts<td>";
				if($baralla=='' && ($_COOKIE['jugador']==$id || isset($_COOKIE['admin']) ))
				{
					echo "<select id=baralla_".$roww['id']." 
						onchange=setejaBaralla(".$roww['id'].")>";
					echo "	<option>--SELECCIONA--";
					$sql="SELECT * FROM baralles ORDER BY nom";
					$resss=mysql_query($sql) or die('error');
					while($rowww=mysql_fetch_assoc($resss))
					{
						echo "<option value=".$rowww['id'].">".$rowww['nom'];
					}
					echo "</select>";
				}
				else
				{
					if($baralla>0)
					{
						$resss=mysql_query("SELECT nom FROM baralles WHERE id=$baralla");
						$nomBaralla=mysql_fetch_assoc($resss);
						echo $nomBaralla['nom'];
						//boto esborra baralla
						if($_COOKIE['jugador']==$id || isset($_COOKIE['admin']) )
							echo " <button 
								onclick=window.location='controller/setejaBaralla.php?id=".$roww['id']."&baralla='
								>Esborra</button>";
					}
				}
				$participacions++;
			}
		}
		echo "<tr><th>TOTAL<td colspan=2 align=center><b>$punts_totals punts</b> (".round($punts_totals/$participacions,1)." punts/torneig)";
	?>
</table>

<?php
//Boto esborrar jugador admin
if(isset($_COOKIE['admin']))
	echo "<br><button 
		style='background-color:#f20;padding:1em' 
		onclick=esborrar()
		>Esborrar Jugador
		</button>";
?>
