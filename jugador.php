<?php
	include 'mysql.php';
	$id=$_GET['id'];
?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
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
<?php include_once("analytics.php") ?>
<?php include 'menu.php' ?>
<?php
	//avis de sessio no iniciada
	if(!isset($_COOKIE['jugador']))
	{
		echo "<div style='padding:1em;font-size:11px;background:#395693;color:white'>
			<form action=controller/login_jugador.php method=get>
				<input name=id value=$id hidden>
				<input name=pass type=password placeholder=Contrasenya size=12 maxlength=10> <button>Inicia Sessió</button>
				<a href=# style=color:white onclick=\"alert('Per saber la teva contrasenya contacta en Lluís al Whatsapp')\">No sé la contrasenya</a>
			</form>
		</div>";
	}
?>

<?php
	$sql="SELECT * FROM jugadors WHERE id=$id";
	$res=mysql_query($sql);
	$row=mysql_fetch_assoc($res);
?>

<!--TITOL-->
<h2><a href=jugadors.php>Jugadors</a> &rsaquo; <?php echo $row['nom'] ?></h2>

<!--LLISTA DE CARTES EN VENTA-->
<div style=margin:1em class=inline>
	<?php
		if($row['mkm']!="")
		{ 
			?>
				<button style="background-color:#af0;padding:1em"
					onclick="window.open('https://www.magiccardmarket.eu/?mainPage=browseUserProducts&idCategory=1&idUser=<?php echo $row['mkm']?>')"
					>Veure cartes en venda
				</button>
			<?php	
		}
		else
		{
			?><div style=text-align:left>
				No hi ha usuari de Magiccardmarket associat.
				<br>
				Si vols vincular-lo, diga-li el teu nom d'usuari
				<br> 
				a en Lluís pel Whatsapp
			</div><?php
		}
	?>
</div>

<!--PUNTS DEL JUGADOR A CADA TORNEIG-->
<table class=inline>
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
			$resultat=$roww['id'];
			$punts=$roww['punts'];
			$punts_totals+=$punts;
			if($punts=='') $punts=0;

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

						if($roww['llista']=="")
							echo $nomBaralla['nom'];
						else
							echo "<a href=llista.php?id=$resultat>".$nomBaralla['nom']."</a>";

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
		$ratio= $participacions>0 ? round($punts_totals/$participacions,1) : 0;
		echo "<tr><th>TOTAL<td colspan=2 align=center><b>$punts_totals punts</b> ($ratio punts/torneig)";
	?>
</table>

<?php
	//Boto esborrar jugador admin
	if(isset($_COOKIE['admin']))
	{
		?>
			<fieldset style=max-width:30%;margin-top:1em><legend>Admin</legend>
				<form action=controller/canviaMKM.php method=POST>
					<input name=id type=hidden value='<?php echo $id ?>'>
					<input name=mkm placeholder='mkm id'>
					<button type=submit>Actualitza mkm</button>
				</form>
				<hr style=margin:10px>
				<button style='background-color:#f20;padding:1em' onclick=esborrar()>Esborrar Jugador</button>
			</fieldset>
		<?php
	}
?>
