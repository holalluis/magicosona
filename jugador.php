<?php 
	include 'mysql.php'; 
	//entrada: id jugador
	$id=$_GET['id'];

	//get player info
	$sql="SELECT * FROM jugadors WHERE id=$id";
	$res=mysql_query($sql);
	$row=mysql_fetch_assoc($res);
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
		.icon-edit:before{content:"\270e";}
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
				<button>Accedeix</button>
				<a href=# style="color:white;margin-left:5px" onclick="alert('Per reiniciar la teva contrasenya contacta en Lluís al Whatsapp')">No recordo la contrasenya</a>
			</form>
		</div> <?php
	}
?>

<!--TITOL--><h2><?php echo $nom ?></h2>

<!--COLUMNA DADES-->
<div class=inline style="text-align:left;width:49%;">
	<h4>Informació</h4>

	<ul style="text-align:left;padding-left:1em;display:block;">
		<!--botó modificar dades-->
		<?php
			if($_COOKIE['jugador']==$id)
				echo "<button onclick=window.location='editaDadesJugador.php' style='padding:1em 0.7em'>&#128221; Modificar dades</button>";
		?>

		<!--DCI-->
		<li>DCI:  
		<?php 
			if($dci)
			{ 
				echo $dci;
				echo " (<a href='https://www.wizards.com/Magic/PlaneswalkerPoints/$dci' target=_blank>Planeswalker Points</a>)";
			}
			else echo "<span style=color:#999>no entrat</span>";
		?>

		<!--LLISTA DE CARTES EN VENTA-->
		<?php if($mkm)
			{ 
				?>
					<li>Magiccardmarket: <a href='https://www.magiccardmarket.eu/?mainPage=browseUserProducts&idCategory=1&idUser=<?php echo $mkm ?>' >Veure</a>
				<?php	
			}
			else echo "<li><span style=color:#999>Magiccardmarket no vinculat</span>";
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
				include 'dataProximTorneig.php';
				$assisteix=mysql_num_rows(mysql_query("SELECT 1 FROM assistentsProximTorneig WHERE id_jugador=$id"));
				$data=date("d/m/Y",$proximUnix);
				if($assisteix)
				{
					//si ja ha confirmat, permet enviar la llista
					$nom = explode(" ",$nom)[0]; //Agafa el primer nom
					echo "$nom assistirà al <a href=assistents.php>pròxim torneig ($data)</a>";

					$llista=current(mysql_fetch_assoc(mysql_query("SELECT llista FROM assistentsProximTorneig WHERE id_jugador=$id")));

					//si el client és jugador id o admin
					if($id==$_COOKIE['jugador'] || isset($_COOKIE['admin']))
					{
						if($llista=="")
						{
							echo "<li><span style=color:#999>Llista encara no enviada";
							?>
								<button onclick=mostraMenuLlista() style="display:block;margin:0.5em 0;padding:1.5em"> Envia la llista (només tu la podràs veure) </button>
							<?php
						}
						if($llista!="")
						{
							echo " 
								<br><div 
										onclick=mostraMenuLlista() 
										class=inline
										style='padding:0.3em;
												border:1px solid #ccc;
												margin:0.5em 0;cursor:cell;min-width:49%;
												box-shadow: 0 1px 2px rgba(0,0,0,.1);' 
												id=llistaContainer 
												title='Click per modificar'>
									<style> #llistaContainer:hover {background:#abc} </style>
									<h5>Llista pròxim torneig (només visible per tu)</h5>
									<pre id=llista style=margin-top:10px>$llista</pre>
								</div>";
						}
					}
					else
					{
						if($llista)
							echo "<li>Llista enviada (<b>oculta</b>)";
						else
							echo "<li style=color:#999>Llista no enviada";
					}
				}
				else
				{
					echo "<span style=color:#999>No ha confirmat assistència al <a href=assistents.php>pròxim torneig ($data)</a>";	
					if($id==$_COOKIE['jugador'] || isset($_COOKIE['admin']))
					{ ?>
						<button onclick=emVullApuntar() >Apuntar-me al pròxim torneig!</button>
						<script>
							function emVullApuntar()
							{
								if(confirm('Vols confirmar que assistiràs al pròxim torneig (<?php echo $data ?>)?'))
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

<!--COLUMNA TORNEIGS-->
<div class=inline style="width:49%;text-align:left;padding-left:0.4em">
	<h4>Historial torneigs</h4>
	<table style=width:97%>
		<tr><th>Torneig<th>Baralla<th>Punts
		<?php
			$punts_totals=0;
			$sql="SELECT * FROM esdeveniments ORDER BY data DESC";
			$res=mysql_query($sql);
			$participacions=0;
			while($row=mysql_fetch_assoc($res))
			{
				$esd=$row['id'];
				$data=date("d/m/Y",strtotime($row['data']));
				$esd_jugadors = current(mysql_fetch_assoc(mysql_query("SELECT COUNT(*) FROM resultats WHERE id_esdeveniment=$esd")));

				$sql="SELECT * FROM resultats WHERE id_esdeveniment=$esd AND id_jugador=$id";
				$ress=mysql_query($sql) or die('error al query');
				$roww=mysql_fetch_assoc($ress);
				$resultat=$roww['id'];
				$punts=$roww['punts'];

				if($punts=='') $punts=0;
				$punts_totals+=$punts;

				//Baralla utilitzada al torneig
				$baralla=$roww['baralla'];

				if($punts!=0)
				{
					echo "<tr><td><a href=esdeveniment.php?id=$esd>".$row['nom']." · $esd_jugadors jugadors · $data</a>";
					echo "<td>";
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
								echo " <button class=icon-edit onclick=window.location='controller/setejaBaralla.php?id=".$roww['id']."&baralla='></button>";
						}
						else
							echo "<span style='color:#ccc'>N/A</span>";
					}
					echo "<td>$punts";
					
					$participacions++;
				}
			}

			//si no ha participat, posa "no ha participat"
			if($participacions==0) echo "<tr><td colspan=3>Encara no ha participat a cap torneig";

			//punts totals i punts per torneig
			$ratio= $participacions>0 ? round($punts_totals/$participacions,1) : 0;
			echo "<tr><th align=center>TOTAL<th colspan=2 align=center><b>$punts_totals punts</b> ($ratio punts/torneig)";
		?>
	</table>
</div>

<?php
	//ADMIN
	if(isset($_COOKIE['admin']))
	{
		?>
			<fieldset style=max-width:30%;margin-top:1em><legend>Admin</legend>
				<button style='background-color:#f20;padding:1em' onclick=esborrar()>Esborrar Jugador</button>
				<button onclick="alert('<?php echo $pas ?>')">Pass</button>
			</fieldset>
		<?php
	}
?>
