<?php
	// PÀGINA PRINCIPAL
	include 'mysql.php';
	include 'dataProximTorneig.php';
	function comptaPot()
	{
		$pot=0; //euros
		$res=mysql_query("SELECT * FROM esdeveniments");
		while($row=mysql_fetch_assoc($res))
		{
			$id_esdeveniment=$row['id'];
			$sql="SELECT COUNT(id) FROM resultats WHERE id_esdeveniment=$id_esdeveniment";
			$participants=current(mysql_fetch_assoc(mysql_query($sql)));
			$pot+=2*$participants;
		}
		return $pot;
	}
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
	<link rel=stylesheet type="text/css" href="estils.css" />
	<title>Magic Osona - Pàgina Principal</title>
	<?php include 'compteEnrere.php' ?>
	<script>
		function nouAssistent()
		//posa un nou jugador a la llista d'assistents al proxim torneig
		{
			var id_jugador = document.getElementById('id_assistent').value;
			window.location='nouAssistent.php?id_jugador='+id_jugador
		}
		function ordena(id)
		//ordenar la taula per punts
		{
			//t.rows[i].cells[j] == TAULA
			var i,j,t = document.getElementById(id)
			var files = t.rows.length-1
			var columnes=t.rows[0].cells.length-1
			//declarar array a ordenar i array a ordenat per despres comparar-los
			var ordenar = new Array(files)
			var ordenat = new Array(files)
			//contingut a ordenar
			for(i=0;i<files;i++)
			{
				//ordena per la ultima columna
				ordenar[i]=t.rows[i+1].cells[columnes].innerHTML
				ordenat[i]=t.rows[i+1].cells[columnes].innerHTML
			}
			//ordena
			ordenat.sort(function(a,b){return b-a})
			//array de ordre
			var ordre=new Array(files)
			for(i=0;i<files;i++)
			{
				for(j=0;j<files;j++)
				{
					if(ordenar[j]==ordenat[i])
						ordre[i]=j
				}
				//treu l'index que has trobat
				ordenar[ordre[i]]=""
			}
			// FER UNA COPIA DE TOTES LES FILES 
			var trs=new Array(files)
			//copia tots els <tr>
			for(i=0;i<files;i++)
				trs[i]=t.rows[i+1].cloneNode(true)
			//elimina tota la taula
			for(i=0;i<files;i++)
				t.deleteRow(-1)
			//POSA LA TAULA EN ORDRE
			for(i=0;i<files;i++)
			{
				//seteja la primera columna amb el numero correcte
				trs[ordre[i]].cells[0].innerHTML=i+1
				t.appendChild(trs[ordre[i]])
			}
		}
		function init()
		//es crida a body onload
		{
			//ordena la taula de puntuació
			ordena('taula');

			//posa els 16 primers en color daurat
			for(var i=0;i<16;i++)
				document.getElementsByClassName('top')[i].style.backgroundColor='gold'
		}
	</script>
</head><body onload=init()><center>
<?php include 'menu.php' ?>
<!-- PROXIM ESDEVENIMENT -->
<div style="padding:0.8em;background-color:gold">
	<?php 
		echo "<b> Pròxim torneig: $nomProximTorneig: </b>";
		//compta el numero de jugadors apuntats
		$assistents=mysql_num_rows(mysql_query("SELECT * FROM assistentsProximTorneig"));
		echo "$dataProximTorneig | ";
		echo "<a href=assistents.php>Jugadors inscrits ($assistents)</a>";
	?>
</div> 

<!--MENU ADMIN--> <?php include 'menuAdmin.php' ?>
<!--LOGO-->
<h2 onclick="window.location.reload()" style="cursor:pointer">
	Magic Osona Lliga 2016 — Pàgina Principal
</h2>

<!--CLASSIFICACIÓ-->
<div style=margin-bottom:0;padding:0.5em>
<b> CLASSIFICACIÓ </b> - Pot acumulat per la final: <b><?php echo comptaPot() ?> €</b> 
</div>

<table cellpadding=5 id=taula>
	<tr><th>Top<th>Jugador
	<?php
		// Llista d'esdeveniments
		$sql="SELECT * FROM esdeveniments ORDER BY data ASC";
		$res=mysql_query($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$id=$row['id'];
			$nom=$row['nom'];
			echo "<th><a href=esdeveniment.php?id=$id>$nom</a>";
		}
	?>
	<th>Total
	<?php
		// Llista de jugadors amb les seves puntuacions
		$sql="SELECT * FROM jugadors";
		$res=mysql_query($sql);
		$i=1;
		while($row=mysql_fetch_assoc($res))
		{
			//comprova quants punts han fet a cada esdeveniment
			$total_punts=0;
			echo "<tr>";
			echo "	<td class=top align=center>$i
				<td><a href=jugador.php?id=".$row['id'].">".$row['nom']."</a>";
			$sql="SELECT * FROM esdeveniments ORDER BY data ASC";
			$ress=mysql_query($sql);
			while($roww=mysql_fetch_assoc($ress))
			{
				echo "<td align=center>";
				//per cada esdeveniment troba els resultats de cada jugador
				$sql="SELECT * FROM resultats WHERE id_jugador=".$row['id']." AND id_esdeveniment=".$roww['id'];
				$resss=mysql_query($sql);
				while($rowww=mysql_fetch_assoc($resss))
				{
					if($rowww['punts']!=0){ echo $rowww['punts'];}
					$total_punts+=$rowww['punts'];
				}
			}
			echo "<td style=font-weight:bold align=center>$total_punts";
			$i++;
		}
	?>
</table>
<script>
function login()
{
	var p=prompt('Contrasenya?')
	if(p) window.location='controller/login.php?pass='+p
}
</script>
<br><br><a href=# onclick=login()>Admin</a>
