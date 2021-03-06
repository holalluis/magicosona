<?php
	//Pàgina per mostrar una llista de jugadors apuntats al pròxim torneig
	include 'mysql.php';
	include 'dataProximTorneig.php';
	$ass = isset($_GET['ass']) ? $_GET['ass'] : "si";

	//compta el total de jugadors a la lliga
	$sql="SELECT 1 FROM jugadors";
	$result=$mysql->query($sql) or die('error');
	$total=mysqli_num_rows($result);

	if($ass=="si") {
		//request SI
		$sql="SELECT * FROM assistentsProximTorneig,jugadors WHERE id_jugador=jugadors.id ORDER BY jugadors.nom";	
	}else{
		//request NO
		$sql="SELECT * FROM jugadors 
			WHERE NOT EXISTS (SELECT 1 FROM assistentsProximTorneig WHERE assistentsProximTorneig.id_jugador = jugadors.id)
			ORDER BY nom ASC";
	}
	$result=$mysql->query($sql) or die('error');
	$n=mysqli_num_rows($result);
?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Assistents Pròxim Torneig</title>
	<script>
		//pel whatsapp
		function llistaWA() {
			var t=document.getElementById('taula')
			var num,nom,torneig='<?php echo current(mysqli_fetch_assoc($mysql->query('SELECT COUNT(*)+1 FROM esdeveniments'))) ?>'
			var str=""
			str+="Inscrits al Torneig "+torneig+", <?php echo $dataProximTorneig ?>:\r\n";
			str+="========================\r\n";
			for(var i=1;i<t.rows.length;i++)//comença per 1 pq hi ha una fila extra a sobre de tot
			{
				num = t.rows[i].cells[0].textContent;
				nom = t.rows[i].cells[1].textContent;
				str+=num+" "+nom+"\n"
			}
			str+="========================\r\n";
			str+="Falten <?php echo $falten?> dies!\r\nmagicosona.com\r\n";
			prompt("Copia amb ctrl-c",str)
		}
		function eliminaAssistent(id) {
			window.location='controller/eliminaAssistent.php?id_jugador='+id
		}
		function excel() {
			//Agafa la taula id=taula
			var taula=document.getElementById('taula');
			//string on escriurem l'arxiu csv
			var str="Num;Nom;Inscrit;Llista;Menu;Entrepa;Beguda\r\n";
			//recorre la taula en loop
			for(var i=1; i<taula.rows.length; i++)
			{
				str += (i) + ";"
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
	if($ass=="si") {
		$premi = $n*5;
		?>
			<div style='display:none;margin:0.3em;background:orange;padding:0.5em;text-align:left;border-radius:0.5em;box-shadow: 0 5px 5px -5px rgba(0,0,0,0.3);'>
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
<h4 style="background:gold;border-bottom:1px solid #ccc;margin:0;margin-bottom:5px">
	<p>
		Per inscriure't <a href=login.php>inicia sessió</a>
	</p>
	<p>
		Si no tens perfil <a href=contacte.php>contacta amb nosaltres</a>
	</p>
</h4>

<!--contingut-->
<div class=flex>
	<!--imatge-->
	<div style=max-width:48%;>
		<?php
			if(file_exists('img/torneigs/proxim.jpg'))
			{ ?>
				<div>
					<img src="img/torneigs/proxim.jpg" alt="imatge proxim torneig" style=max-width:99%;cursor:pointer; onclick=window.open('img/torneigs/proxim.jpg')> 
				</div>
			<?php }
		?>
	</div>

	<!--llista container-->
	<div style=max-width:50%;>
		<!--botons EXCEL i whatsapp-->
		<?php if(isset($_COOKIE['admin'])) { ?>
			<div class=flex id=botonera > 
				<button onclick=excel()>Generar Excel Assistents</button> &emsp;
				<button onclick=llistaWA()>Llista pel Whatsapp</button> &emsp;
				<?php
					if($ass=="si")
						echo "<button onclick=window.location='assistents.php?ass=no'>Veure NO inscrits</a>";
					else
						echo "<button onclick=window.location='assistents.php?ass=si'>Veure inscrits</a>";
				?>
				<style>
					#botonera {
						padding:0.5em;
					}
					#botonera button {
						padding:1em;
					}
				</style>
			</div>
		<?php } ?>

		<!--llista-->
		<table id=taula>
			<tr><td colspan="<?php if(isset($_COOKIE['admin'])){echo 5;}else{echo 4;}?>" style=text-align:center>
				<?php if($ass=="no") echo "No inscrits"; else echo "Inscrits" ?> al pròxim torneig
			</tr>
			<?php
				$i=1;
				while($row=mysqli_fetch_assoc($result)) {
					$nom=$row['nom'];
					$id=$row['id'];
					$llista=$row['llista'] ? "<small title='Llista oculta' style=cursor:help>Llista enviada</small>" : "<span style=color:#999><small>~llista no enviada</small></span>";
					$dci=$row['dci'] ? $row['dci'] : "<span style=color:#999>Falta DCI</span>";

					//han d'estar juntes pel tema whatsap les línies (numero i nom)
					echo "<tr>
						<td><small>$i</small><td><a href=jugador.php?id=$id>$nom</a><td><small>$dci</small>
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
