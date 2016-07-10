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
	<style>
		h4{text-align:left;font-weight:bold}
	</style>
</head><body><center>
<?php include_once("analytics.php") ?>
<?php include 'menu.php' ?>
<?php
	//avis de sessio no iniciada
	if(!isset($_COOKIE['jugador']))
	{
		?>
			<div style='padding:1em;font-size:11px;background:#395693;color:white'>
				<form id=login_form action=controller/login_jugador.php method=get>
					<style>
						#login_form {line-height:2em}
						#login_form input {
							padding:0;
							height:25px;
							width:90px;
							border:1px solid #ccc;
							border-right:none;
							outline:none;
							padding-left:5px;
						}
						#login_form button {
							border-radius:0;
							height:27px;
							padding:0 5px;
							margin-left:-2px
						}
					</style>
					<input name=id value="<?php echo $id?>" style=display:none>
					<input name=pass type=password placeholder=Contrasenya maxlength=10> 
					<button>Inicia Sessió</button>
					<a href=# style="color:white;margin-left:5px" onclick="alert('Si vols reiniciar la teva contrasenya, demana-ho a en Lluís per Whatsapp')">No recordo la contrasenya</a>
				</form>
			</div>
		<?php
	}
?>

<?php
	$sql="SELECT * FROM jugadors WHERE id=$id";
	$res=mysql_query($sql);
	$row=mysql_fetch_assoc($res);
	$mkm=$row['mkm'];
	$dci=$row['dci'];
?>

<!--TITOL-->
<h2><a href=jugadors.php>Jugadors</a> &rsaquo; <?php echo $row['nom'] ?></h2>

<!--COLUMNA TORNEIGS-->
<div class=inline style="width:49%;text-align:left;">
	<h4>Dades torneigs</h4>
	<table style=width:96%>
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
					echo "<tr><td><a href=esdeveniment.php?id=".$row['id'].">".$row['nom']."</a>";
					echo "<td>$punts<td>";
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
								echo "<a style=color:#aaa title='Llista no disponible' href=llista.php?id=$resultat>".$nomBaralla['nom']."</a>";
							else
								echo "<a href=llista.php?id=$resultat>".$nomBaralla['nom']."</a>";

							//boto esborra baralla
							if($_COOKIE['jugador']==$id || isset($_COOKIE['admin']) )
								echo " <button style='float:right;margin-left:1em;font-size:11px'
									onclick=window.location='controller/setejaBaralla.php?id=".$roww['id']."&baralla='
									>Esborra</button>";
						}
						else
							echo "<span style='color:#ccc'>N/A</span>";
					}
					$participacions++;
				}
			}
			$ratio= $participacions>0 ? round($punts_totals/$participacions,1) : 0;
			echo "<tr><th align=center>TOTAL<th colspan=2 align=center><b>$punts_totals punts</b> ($ratio punts/torneig)";
		?>
	</table>
</div>

<!--COLUMNA DADES-->
<div class=inline style="width:49%;">
	<h4>Dades jugador
		<?php
			if($_COOKIE['jugador']==$id)
				echo "<button onclick=window.location='editaDadesJugador.php'>Modificar</button>";
		?>
	</h4>

	<ul style="text-align:left;padding-left:0.4em">
		<!--DCI-->
		<?php 
			if($dci)
			{ 
				?>
					<li>DCI: <?php echo $dci?>
					<li><a href="https://www.wizards.com/Magic/PlaneswalkerPoints/<?php echo $dci?>" target=_blank>Planeswalker Points</a>
				<?php 
			}
			else echo "<li>No hi ha DCI associat";
		?>

		<!--LLISTA DE CARTES EN VENTA-->
		<?php if($mkm)
			{ 
				?>
					<li><a href='https://www.magiccardmarket.eu/?mainPage=browseUserProducts&idCategory=1&idUser=<?php echo $mkm ?>' >Veure cartes Magiccardmarket</a>
				<?php	
			}
			else echo "<li>No hi ha usuari de Magiccardmarket associat";
		?>

		<!--ASSISTEIX AL PROXIM TORNEIG-->
		<li assistencia>
		<style>
			li[assistencia] button
			{
				display:block;
				margin:1em 0;
				padding:0.7em;
			}
		</style>

			<?php
				include 'dataProximTorneig.php';
				$assisteix=mysql_num_rows(mysql_query("SELECT 1 FROM assistentsProximTorneig WHERE id_jugador=$id"));
				$data=date("d/m/Y",$proximUnix);
				if($assisteix)
				{
					//si ja ha confirmat, permet enviar la llista
					echo "Assistirà al pròxim torneig (<a href=assistents.php>$data</a>)";

					$llista=current(mysql_fetch_assoc(mysql_query("SELECT llista FROM assistentsProximTorneig WHERE id_jugador=$id")));

					//si el visitant és el mateix jugador
					if($id==$_COOKIE['jugador'])
					{
						?>
							<button onclick=mostraMenuLlista()> Envia la llista (només tu la podràs veure) </button>
							<script>
								function mostraMenuLlista()
								{
									//nou popup
									var div=document.createElement('div');
									document.body.appendChild(div)
									div.className="popup"
									div.style.top="20%"
									div.style.left="30%"
									//titol
									var h3 = document.createElement('h3')
									h3.innerHTML="Llista pel pròxim torneig"
									div.appendChild(h3)
									//nova textarea
									var text=document.createElement('textarea')
									div.appendChild(text)
									text.placeholder="Enganxa aquí la teva llista"
									//llista existent?
									var pre = document.querySelector('pre#llista')
									if(pre) text.value=pre.innerHTML
									text.focus()
									//boto ok
									var btn=document.createElement('button')
									div.appendChild(btn)
									btn.innerHTML="Enviar"
									btn.onclick=function()
									{
										var llista=text.value;
										var sol=new XMLHttpRequest()
										sol.open('POST','controller/llistaProximTorneig.php',true)
										sol.setRequestHeader("Content-type","application/x-www-form-urlencoded");
										sol.onreadystatechange=function()
										{
											if(sol.readyState==4 && sol.status==200) 
											{
												alert(sol.responseText);
												document.body.removeChild(div);
												window.location.reload()
											}
										}
										sol.send('llista='+llista)
									}
									//boto cancelar
									var btnc=document.createElement('button')
									div.appendChild(btnc)
									btnc.innerHTML="Cancela"
									btnc.onclick=function()
									{
										document.body.removeChild(div);
									}
								}
							</script>

						<?php
							if($llista!="")
							{
								echo " 
									<div style='padding:0.3em;border:1px solid #ccc;margin:10px 0'>
										<h5>Llista enviada pel pròxim torneig</h5>
										<h6>(Només tu la pots veure)</h6>
										<pre id=llista style=margin-top:10px>$llista</pre>
									</div>";
							}
					}
				}
				else
				{
					echo "No ha confirmat la seva assistència al pròxim torneig (<a href=assistents.php>$data</a>)";	
					if($id==$_COOKIE['jugador'])
					{ ?>
						<button onclick=emVullApuntar() >Em vull apuntar!</button>
						<script>
							function emVullApuntar()
							{
								if(confirm('Vols confirmar la teva assistència al pròxim torneig?'))
								{
									var sol = new XMLHttpRequest()
									sol.open('GET','nouAssistent.php?id_jugador=<?php echo $id?>',false);
									sol.send()
									window.location.reload();
								}
							}
						</script>
					<?php }
				}
			?>
	</ul>
</div>

<?php
	//ADMIN
	if(isset($_COOKIE['admin']))
	{
		?>
			<fieldset style=max-width:30%;margin-top:1em><legend>Admin</legend>
				<button style='background-color:#f20;padding:1em' onclick=esborrar()>Esborrar Jugador</button>
			</fieldset>
		<?php
	}
?>
