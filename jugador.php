<?php
	$id=$_GET['id'];
	include 'mysql.php';
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet type="text/css" href="estils.css" />
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
		function infoVenta()
		{
			alert("És responsabilitat de cada jugador de contactar amb els altres jugadors per fer compra-venta de cartes. El Totoptero Team no ens fem responsables del preu ni la disponibilitat de les cartes que els jugadors llistin dins la web.")
		}
	</script>
</head><body><center>
<?php include 'header_sessio.php' ?>
<?php include 'cover.php' ?>
<?php include 'menu.php' ?>
<?php
	$sql="SELECT * FROM jugadors WHERE id=$id";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
?>

<!--TITOL-->
<h2><?php echo $row['nom'] ?></h2>

<?php
	//avis de sessio no iniciada
	if(!isset($_COOKIE['jugador']))
	{
		echo "<div style='border:1px solid #ccc;max-width:50%;font-size:11px'>
			<form action=login_jugador.php method=get>
				<input name=pass type=password placeholder=Contrasenya size=10 maxlength=10> 
				<input name=id value=$id hidden>
				 <button>Inicia Sessió</button>
				Per saber la teva contrasenya contacta amb en Lluís pel Whatsapp
			</form>
		</div>";
	}
?>

<br>

<!--PUNTS DEL JUGADOR A CADA TORNEIG-->
<table cellpadding=5>
	<tr><th>Torneig<th>Punts<th>Baralla
	<?php
		$punts_totals=0;
		$sql="SELECT * FROM esdeveniments ORDER BY data ASC";
		$res=mysql_query($sql);
		while($row=mysql_fetch_array($res))
		{
			$esd=$row['id'];
			$sql="SELECT * FROM resultats WHERE id_esdeveniment=$esd AND id_jugador=$id";
			$ress=mysql_query($sql);
			$roww=mysql_fetch_array($ress);
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
					while($rowww=mysql_fetch_array($resss))
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
						$nomBaralla=mysql_fetch_array($resss);
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
		echo "<tr><th>TOTAL<td colspan=1 align=center><b>$punts_totals punts</b> <td>(".round($punts_totals/$participacions,1)." punts/torneig)";
	?>
</table>

<br>

<!--LLISTA DE CARTES EN VENTA-->
<table>
	<tr><th 
		<?php 
			if($_COOKIE['jugador']==$id || isset($_COOKIE['admin']) )
			     echo "colspan=5";
			else echo "colspan=4";
		?>
	>Cartes en venta 
	(<?php
		//compta el nombre de cartes en venta
		echo mysql_num_rows(mysql_query("SELECT 1 FROM ofertes WHERE id_jugador=$id"));
	?>)

	&nbsp;&nbsp;&nbsp;&nbsp;

	<button onclick="window.location='album.php?id=<?php echo $id ?>'"
		style="background-color:#af0;padding:1em"
		>Veure Àlbum Visual</button>

	<tr><th>Carta<th>Quantitat<th>Foil<th>Preu
		<?php 
			if($_COOKIE['jugador']==$id || isset($_COOKIE['admin']) ) echo "<th>Opcions";
		?>
	<?php
		$sql="SELECT * FROM ofertes WHERE id_jugador=$id ORDER BY carta ASC,preu ASC";
		$res=mysql_query($sql);
		while($row=mysql_fetch_array($res))
		{
			$id_oferta=$row['id'];
			$carta=mysql_real_escape_string($row['carta']);
			$quantitat=$row['quantitat'];
			$foil=$row['foil']? "Sí" : "<span style=color:#ccc>No</span>";
			$preu=$row['preu'];
			echo "<tr>";
			echo "<td><a
				onmousemove=\"mostraCover('$carta',event)\"
				onmouseout=amagaCover()
				>".str_replace('\\','',$carta)."</a>";
			echo "<td align=center>$quantitat";
			echo "<td align=center>$foil";
			echo "<td align=center>$preu €";
			if($_COOKIE['jugador']==$id || isset($_COOKIE['admin']) )
			{
				echo "<td>";
				if($quantitat>  0) echo "<button onclick=window.location='controller/modificaOfertaResta1.php?id=$id_oferta'>-1</button> ";
				if($quantitat<=10) echo "<button onclick=window.location='controller/modificaOfertaSuma1.php?id=$id_oferta'>+1</button> ";
				echo "<button onclick=if(confirm('Continuar?')){window.location='controller/esborraOferta.php?id=$id_oferta'}>Esborra</button>";
			}
		}
		//NOVA CARTA EN VENTA FORMULARI
		if($_COOKIE['jugador']==$id || isset($_COOKIE['admin']) )
		{
			echo "
				<tr><td align=center>Afegir nova carta <br>(NOM EN ANGLÈS)
				<form method=POST action='controller/novaOferta.php'>
					<input name=carta 
						placeholder='p.ex. Remand' 
						required 
						autocomplete=off 
						maxlength=50
						size=13>
					<td align=center><select name=quantitat>
						<option>1 <option>2 <option>3 <option>4 <option>5 <option>6 <option>7 <option>8 <option>9 <option>10
					</select>
					<td align=center><input name=foil type=checkbox>
					<td><input name=preu size=3 placeholder='preu' required autocomplete=off> €
					<td align=center><input name=id_jugador value=$id style=display:none>
					<button type=submit>Guarda</button>
				</form>";
		}
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

<br><a href="javascript:infoVenta()">Informació</a>
