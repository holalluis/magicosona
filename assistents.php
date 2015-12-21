<?php
	//Pàgina per mostrar una llista de jugadors apuntats al pròxim torneig

	include 'mysql.php';
	include 'dataProximTorneig.php';

	//compta el total de jugadors a la lliga
	$sql="SELECT 1 FROM jugadors";
	$result=mysql_query($sql) or die('error');
	$total=mysql_num_rows($result);

	//request: jugadors apuntats al proxim torneig
	$sql="SELECT * FROM assistentsProximTorneig,jugadors WHERE id_jugador=jugadors.id ORDER BY jugadors.nom";	
	$result=mysql_query($sql) or die('error al request');

	//calcula el nombre de jugadors apuntats
	$n=mysql_num_rows($result);
?>
<!doctype html> <html> <head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet type="text/css" href="estils.css" />
	<title>Assistents Pròxim Torneig</title>
	<?php include 'compteEnrere.php' ?>
	<script>
		function llistaWA()
		//confirm per fer copiar pegar
		{
			var num,nom
			var t = document.getElementById('taula')
			var str=""
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

<div style=padding:0.5em>
	<a href='index.php'>Pàgina principal</a>
	|
	Jugadors inscrits
	|
	<a href='assistents_NO.php'>Jugadors NO inscrits</a>
</div>

<h2>Jugadors inscrits al pròxim torneig</h2>
<h4>
	Hi ha <?php echo $n."/".$total ?> jugadors inscrits.
	<b>Inscripcions</b>: Whatsapp (grup "Magic Osona") o <a href=mailto:holalluis@gmail.com>holalluis@gmail.com</a>
</h4>

<!-- PROXIM ESDEVENIMENT -->
<div style="padding:0.5em;background-color:gold">
	<?php echo "<b> Pròxim torneig ($nomProximTorneig):</b> $dataProximTorneig"; ?>
</div> 

<?php include 'menuAdmin.php'; ?>

<table cellpadding=1 id=taula>
	<?php
		$i=1;
		while($row=mysql_fetch_array($result))
		{
			$nom=$row['nom'];
			$id=$row['id'];
			echo "<tr><td>$i<td><a href=jugador.php?id=$id>$nom</a>";

			if(isset($_COOKIE['admin']))
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
