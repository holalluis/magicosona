<?php 
	include 'mysql.php'; 
	//entrada: id jugador
	$id=$_GET['id'];

	//get player info
	$sql="SELECT * FROM jugadors WHERE id=$id";
	$res=$mysql->query($sql);
	$row=mysqli_fetch_assoc($res);
	$nom=$row['nom'];
	$mkm=$row['mkm'];
	$dci=$row['dci'];
	$pas=$row['pass'];
?>
<!doctype html><html><head><?php include'imports.php'?>
	<title><?php echo $nom?></title>
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
		function mostraMenuLlista() {
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
			btn.innerHTML="Guarda"
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
						console.log(sol.responseText);
						document.body.removeChild(div);
						window.location.reload();
					}
				}
				sol.send('id='+<?php echo $id?>+'&llista='+llista)
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
	<style>
		h4{text-align:left;font-weight:bold}
		ul{list-style-type:none}
		.icon-edit:before{content:"\274c";}
	</style>
</head><body><center>
<?php include'menu.php'?>
<?php
	//avis de sessio no iniciada
	if(!isset($_COOKIE['jugador']))
	{ ?>
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
						margin-left:-4px
					}
				</style>
				<input name=id value="<?php echo $id?>" style=display:none>
				<input name=pass type=password placeholder=Contrasenya maxlength=20> 
				<button>ok</button>
				<a href=recuperar.php style="color:white;margin-left:5px">No recordo la contrasenya</a>
			</form>
		</div> <?php
	}
?>
<!--TITOL--><h2><?php echo $row['nom']; ?></h2>

<div id=root class=flex>

<!--COLUMNA DADES-->
<div style="text-align:left;">
	<h4>Informació</h4>

	<ul style="text-align:left;padding-left:0;display:block;">
		<!--botó modificar dades-->
		<?php
			if((isset($_COOKIE['jugador']) && $_COOKIE['jugador']==$id) or isset($_COOKIE['admin']))
			{
				echo "<button onclick=window.location='editaDadesJugador.php?id=$id' style='padding:1em 0.7em'>&#128221; Modificar dades</button>";
			}
		?>

		<!--DCI-->
		<li><b>DCI</b>:  
		<?php 
			if($dci)
			{ 
				echo $dci;
				//echo " (<a href='https://www.wizards.com/Magic/PlaneswalkerPoints/$dci' target=_blank>Planeswalker Points</a>)";
				?>
					<div id=PW><i style=color:#666>Carregant Planeswalker Points...</i></div>
					<script src="pwPoints.js"></script>
					<script>PW.getPoints(<?php echo $dci?>,document.querySelector('#PW'))</script>
					<style>
						#PW { padding:0.5em 0; }
					</style>
				<?php
			}
			else {
				echo "<span style=color:#999><small>~no especificat</small></span>";
			}
		?>

		<!--LLISTA DE CARTES EN VENTA-->
		<?php if($mkm)
			{ 
				?>
					<li><b>Magiccardmarket</b>: 
					<a target=_blank href='https://www.magiccardmarket.eu/?mainPage=browseUserProducts&idCategory=1&idUser=<?php echo $mkm ?>'>
						Veure (id <?php echo $mkm?>)
					</a>
				<?php	
			}
			else echo "<li><b>Magiccardmarket:</b> <span style=color:#999><small>~no especificat</small></span>";
		?>

		<!--ASSISTEIX AL PROXIM TORNEIG-->
		<li assistencia>
		<style>
			li[assistencia] button
			{
				display:block;
				margin:1em 0;
				padding:1.5em;
			}
		</style>

		<?php
			include'dataProximTorneig.php';
			$assisteix=mysqli_num_rows($mysql->query("SELECT 1 FROM assistentsProximTorneig WHERE id_jugador=$id"));
			$data=date("d/m/Y",$proximUnix);
			if($assisteix)
			{
				//si ja ha confirmat, permet enviar la llista
				$nom = explode(" ",$row['nom'])[0]; //Agafa el primer nom
				echo "$nom assistirà al <a href=assistents.php>pròxim torneig</a>";

				//si el jugador ha iniciat sessió i és ell mateix...
				if(isset($_COOKIE['jugador']) && $id==$_COOKIE['jugador'])
				{
					?>
						<button 
							onclick="(function(){
								if(!confirm('Et desapuntaràs del torneig i s\'esborrarà la llista, si l\'has enviat. Continuar?'))return;
								var sol = new XMLHttpRequest()
								sol.open('GET','controller/eliminaAssistent.php?id_jugador=<?php echo $id?>',false);
								sol.send()
								window.location.reload();
							})()"
						>
							&#10060; Em vull desapuntar
						</button>
					<?php
				}

				$llista=current(mysqli_fetch_assoc($mysql->query("SELECT llista FROM assistentsProximTorneig WHERE id_jugador=$id")));

				//si el client és jugador id o admin
				if(isset($_COOKIE['jugador']) && $id==$_COOKIE['jugador'] || isset($_COOKIE['admin']))
				{
					if($llista=="")
					{
						echo "<span style=color:#999><small>~llista no especificada</small>";
						?>
							<big>
								<button onclick=mostraMenuLlista() style="display:block;margin:0.5em 0;padding:1.5em">
									&#128211; ENVIA LA LLISTA (PRIVAT) 
								</button>
							</big>
						<?php
					}
					if($llista!="")
					{
						?>
							<p>
								<div><b>Llista pròxim torneig</b></div>
								<small>Recorda que només la pots veure tu</small>
								<br>
								<small>Clica sobre el requadre per modificar-la</small>
								<div onclick=mostraMenuLlista() id=llistaContainer title='Click per modificar'>
									<style> 
										#llistaContainer {
											padding:0.3em;
											border:1px solid #ccc;
											margin:0.5em 0;cursor:cell;min-width:49%;
											box-shadow: 0 1px 2px rgba(0,0,0,.1);
										}
									</style>
									<pre id=llista style=margin-top:10px><?php echo $llista ?></pre>
								</div>
							</p> 
						<?php
					}
				} else {
					if($llista)
						echo "<li>Llista enviada (<b>oculta</b>)";
					else
						echo "<li style=color:#999><small>~llista no especificada</small>";
				}
			}
			else
			{
				echo "<span style=color:#999><small>~no ha confirmat assistència al pròxim torneig</small>";	
				if(isset($_COOKIE['jugador']) && $id==$_COOKIE['jugador'] || isset($_COOKIE['admin']))
				{ 
					?>
					<button onclick="(function(){
						if(confirm('Confirmar que assistiràs al pròxim torneig (<?php echo $data ?>)?'))
						{
							var sol = new XMLHttpRequest()
							sol.open('GET','nouAssistent.php?id_jugador=<?php echo $id?>',false);
							sol.send()
							window.location.reload();
						}
					})()">&#9989; EM VULL APUNTAR AL PRÒXIM TORNEIG</button>
					<?php 
				}
			}
		?>
	</ul>
</div>

<!--COLUMNA TORNEIGS-->
<div style="text-align:left;padding-left:0.4em">
	<h4>Historial torneigs</h4>

	<table>
		<tr><th>Torneig<th>Baralla<th>Punts
		<?php
			$punts_totals=0;
			$sql="SELECT * FROM esdeveniments ORDER BY data DESC";
			$res=$mysql->query($sql);
			$participacions=0;
			while($row=mysqli_fetch_assoc($res)) {
				$esd=$row['id'];
				$data=date("d/m/Y",strtotime($row['data']));
				$esd_jugadors = current(mysqli_fetch_assoc($mysql->query("SELECT COUNT(*) FROM resultats WHERE id_esdeveniment=$esd")));

				$sql="SELECT * FROM resultats WHERE id_esdeveniment=$esd AND id_jugador=$id";
				$ress=$mysql->query($sql) or die('error al query');
				$roww=mysqli_fetch_assoc($ress);
				$resultat=$roww['id'];
				$punts=$roww['punts'];

				if($punts=='') $punts=0;
				$punts_totals+=$punts;

				//Baralla utilitzada al torneig
				$baralla=$roww['baralla'];

				if($punts!=0) {
					echo "<tr><td>
						<a href=esdeveniment.php?id=$esd>
							<div>".$row['nom']." &mdash; </div>
							<div>
								<small>
									$esd_jugadors jugadors
									<br>
									$data
								</small>
							</div>
						</a>
					";
					echo "<td>";
					if($baralla=='' && (isset($_COOKIE['jugador']) && $_COOKIE['jugador']==$id || isset($_COOKIE['admin']) ))
					{
						echo "<select id=baralla_".$roww['id']." 
										onchange=setejaBaralla(".$roww['id'].")>";
						echo "	<option>--SELECCIONA--";
						$sql="SELECT * FROM baralles ORDER BY nom";
						$resss=$mysql->query($sql) or die('error');
						while($rowww=mysqli_fetch_assoc($resss))
						{
							echo "<option value=".$rowww['id'].">".$rowww['nom'];
						}
						echo "</select>";
					}
					else
					{
						if($baralla>0)
						{
							$resss=$mysql->query("SELECT nom FROM baralles WHERE id=$baralla");
							$nomBaralla=mysqli_fetch_assoc($resss);

							if($roww['llista']=="")
								echo "<a style=color:#aaa title='Llista no disponible' href=llista.php?id=$resultat>".$nomBaralla['nom']."</a>";
							else
								echo "<a href=llista.php?id=$resultat>".$nomBaralla['nom']."</a>";

							//boto esborra baralla
							if(isset($_COOKIE['jugador']) && $_COOKIE['jugador']==$id || isset($_COOKIE['admin']) )
							{
								echo " <button class=icon-edit onclick=window.location='controller/setejaBaralla.php?id=".$roww['id']."&baralla='></button>";
							}
						}
						else
							echo "<span style='color:#ccc'>N/A</span>";
					}
					echo "<td>$punts";
					
					$participacions++;
				}
			}

			//si no ha participat, posa "no ha participat"
			if($participacions==0) echo "<tr><td colspan=3 style=color:#666><small>~Encara no ha participat a cap torneig</small>";

			//punts totals i punts per torneig
			$ratio= $participacions>0 ? round($punts_totals/$participacions,1) : 0;
			echo "<tr><th align=center>TOTAL<th colspan=2 align=center><b>$punts_totals punts</b><br><small>$ratio punts per torneig</small>";
		?>
	</table>
</div>

</div>

<?php
	//ADMIN
	if(isset($_COOKIE['admin']))
	{
		?>
			<fieldset style=margin-top:1em><legend>Admin [perill]</legend>
				<button style='background-color:#f20;padding:1em' onclick=esborrar()>Esborrar Jugador</button>
				<button onclick="alert('<?php echo $pas ?>')">Pass</button>
			</fieldset>
		<?php
	}
?>
