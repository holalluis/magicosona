<?php
	//Pàgina per mostrar una llista de jugadors apuntats al pròxim torneig

	include 'mysql.php';
	include 'dataProximTorneig.php';
	$ass = isset($_GET['ass']) ? $_GET['ass'] : "si";

	//compta el total de jugadors a la lliga
	$sql="SELECT 1 FROM jugadors";
	$result=mysql_query($sql) or die('error');
	$total=mysql_num_rows($result);

	if($ass=="si")
	{
		//request SI
		$sql="SELECT * FROM assistentsProximTorneig,jugadors WHERE id_jugador=jugadors.id ORDER BY jugadors.nom";	
	}
	else
	{
		//request NO
		$sql="SELECT * FROM jugadors 
			WHERE NOT EXISTS (SELECT 1 FROM assistentsProximTorneig WHERE assistentsProximTorneig.id_jugador = jugadors.id)
			ORDER BY nom ASC";
	}
	$result=mysql_query($sql) or die('error');
	$n=mysql_num_rows($result);
?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Assistents Pròxim Torneig</title>
	<script>
		function llistaWA() //pel whatsapp
		//confirm per fer copiar pegar
		{
			var t=document.getElementById('taula')
			var num,nom,torneig='<?php echo current(mysql_fetch_assoc(mysql_query('SELECT COUNT(*)+1 FROM esdeveniments'))) ?>'
			var str=""
			str+="Inscrits al Torneig "+torneig+", <?php echo $dataProximTorneig ?>:\r\n";
			str+="========================\r\n";
			for(var i=0;i<t.rows.length;i++)
			{
				num = t.rows[i].cells[0].textContent
				nom = t.rows[i].cells[1].textContent
				str+=num+" "+nom+"\n"
			}
			str+="========================\r\n";
			str+="Queden "+(30-i)+" places. Falten <?php echo $falten?> dies! magicosona.com\r\n";
			prompt("Copia amb ctrl-c",str)
		}
		function nouAssistent()
		{
			var id_jugador = document.getElementById('id_assistent').value;
			window.location='nouAssistent.php?id_jugador='+id_jugador
		}
		function eliminaAssistent(id)
		{
			window.location='controller/eliminaAssistent.php?id_jugador='+id
		}
		function excel()
		{
			//Agafa la taula id=taula
			var taula=document.getElementById('taula');
			//string on escriurem l'arxiu csv
			var str="Num;Nom;Inscrit;Llista;Menu;Entrepa;Beguda\r\n";
			//recorre la taula en loop
			for(var i=0; i<taula.rows.length; i++)
			{
				str += (i+1) + ";"
					str += taula.rows[i].cells[1].textContent
					str += ' \r\n'
			}
			//genera link clickable
			var a         = document.createElement('a');
			a.href        = 'data:text/csv;charset=utf-8,' + encodeURI(str);
			a.target      = '_blank';
			a.download    = 'llista.csv';
			//clica el link
			document.body.appendChild(a);
			a.click();
		}
	</script>
</head><body><center>
<?php include 'menu.php'?>
<!--titol--> <h3>Pròxim torneig: <?php echo $dataProximTorneig?> </h3>

<?php //veure premis
	if($ass=="si")
	{
		$premi = $n*5;
		?>
			<div style='display:none;margin:0.3em;background:orange;padding:0.5em;text-align:left;border-radius:0.5em;box-shadow: 0 5px 5px -5px rgba(0,0,0,0.3);' class=inline>
				<span style='font-weight:bold'>Premis:</span>
				<span style=font-size:18px><?php echo $premi?> €</span> (calculat amb <?php echo $n ?> assistents)
				<br>
				<b>Nota</b>: Els premis es repartiran entre els 8 primers i varien en funció del nombre d'assistents.
				<div> <b>Inscripcions:</b> al grup de Whatsapp 'Magic Osona Lliga' </div>
			</div>
		<?php
	}
?>

<!--com inscriure's-->
<h4 style="background:gold;border-bottom:1px solid #ccc">Per inscriure't <a href=login.php>inicia sessió</a> amb el teu perfil.<br>Si no tens perfil <a href=contacte.php>contacta amb nosaltres</a>.</h4>


<div class=flex>
	<!--imatge-->
	<div style=max-width:48%;>
	<?php
		if(file_exists('img/torneigs/proxim.jpg'))
		{ ?>
			<div>
				<img src="img/torneigs/proxim.jpg" alt="imatge proxim torneig" style=max-width:99%;> 
			</div>
		<?php }
	?>
	</div>

	<!--inscrits-->
	<div style=max-width:50%;>
		<div>
			<?php if($ass=="no") echo "No inscrits"; else echo "Inscrits" ?>
		</div>

		<!--botons EXCEL i whatsapp-->
		<?php if(isset($_COOKIE['admin'])) { ?>
			<div class=flex style=padding:0.5em> 
				<button onclick=excel()>Generar Excel Assistents</button> &emsp;
				<button onclick=llistaWA()>Llista pel Whatsapp</button> &emsp;
				<?php
					if($ass=="si")
						echo "<button onclick=window.location='assistents.php?ass=no'>Veure NO inscrits</a>";
					else
						echo "<button onclick=window.location='assistents.php?ass=si'>Veure inscrits</a>";
				?>
			</div>
		<?php } ?>

		<table id=taula>
			<?php
				$i=1;
				while($row=mysql_fetch_assoc($result))
				{
					$nom=$row['nom'];
					$id=$row['id'];
					$llista=$row['llista'] ? "<span title='Llista oculta' style=cursor:help>Llista enviada</span>" : "<span style=color:#999>Falta llista</dci>";
					$dci=$row['dci'] ? $row['dci'] : "<span style=color:#999>Falta DCI</dci>";

					//han d'estar juntes pel tema whatsap les línies (numero i nom)
					echo "<tr>
						<td>$i<td><a href=jugador.php?id=$id>$nom</a><td>$dci
						<td>$llista";

					if($ass=="si" && isset($_COOKIE['admin']))
						echo "<td><button onclick=eliminaAssistent($id)>Elimina</button>";

					$i++;
				}
			?>
		</table>
	</div>

</div>

<?php include 'footer.php' ?>
