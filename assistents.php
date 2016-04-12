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
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet href="estils.css">
	<title>Assistents Pròxim Torneig</title>
	<script>
		function llistaWA()
		//confirm per fer copiar pegar
		{
			var num,nom
			var t = document.getElementById('taula')
			var torneig = '<?php echo current(mysql_fetch_assoc(mysql_query('SELECT COUNT(*)+1 FROM esdeveniments'))) ?>'
			var str=""
			str+="Torneig "+torneig+", <?php echo $dataProximTorneig ?> \r\n";
			str+="==Inscrits===================\r\n";
			for(var i=0;i<t.rows.length;i++)
			{
				num = t.rows[i].cells[0].textContent
				nom = t.rows[i].cells[1].textContent
				str+=num+" "+nom+"\r\n"
			}
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
</head>
<body><center>
<?php include 'menu.php' ?>

<h3>
	Jugadors <?php if($ass=="no") echo "NO" ?> inscrits al pròxim torneig
	<?php
		echo " ($n/$total) ";

		if($ass=="si")
			echo "<button onclick=window.location='assistents.php?ass=no'>Veure NO inscrits</a>";
		else
			echo "<button onclick=window.location='assistents.php?ass=si'>Veure inscrits</a>";
	?>
</h3>

<div> <b>Inscripcions:</b> al grup de Whatsapp "Magic Osona Lliga" </div>

<?php include 'menuAdmin.php'?>

<!--inscrit-->
<table cellpadding=1 id=taula style="margin:0.5em 0 0.5em 0">
	<?php
		$i=1;
		while($row=mysql_fetch_assoc($result))
		{
			$nom=$row['nom'];
			$id=$row['id'];
			echo "<tr><td>$i<td><a href=jugador.php?id=$id>$nom</a>";

			if($ass=="si" && isset($_COOKIE['admin']))
				echo "<td><button onclick=eliminaAssistent($id)>Elimina</button>";

			$i++;
		}
	?>
</table>

<!--EXCEL-->
<div> 
	<button onclick=excel()>Generar Excel Assistents</button> 
	<button onclick=llistaWA()>Llista pel Whatsapp</button>
</div>
