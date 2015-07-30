<?php include 'mysql.php' ?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet type="text/css" href="estils.css" />
	<title>Lliga Osonenca de Modern - Compra Venta</title>
	<script>
		function init()
		{
			document.getElementById('q').focus()
		}
		function infoVenta()
		{
			alert("És responsabilitat de cada jugador de contactar amb els altres jugadors per fer compra-venta de cartes. El Totoptero Team no ens fem responsables del preu ni la disponibilitat de les cartes que els jugadors llistin dins la web.")
		}
	</script>
	<style>
		table{display:inline-block;vertical-align:top}
	</style>
</head>
<body onload=init()><center>
<?php include 'header_sessio.php' ?>
<?php include 'cover.php' ?>
<?php include 'menu.php' ?>

<h2 onclick=window.location='compraVenta.php' style="cursor:pointer">
	Compra-Venta de Cartes
</h2>

<!--busca cartes-->
<form style=margin:1em> 
	<input id=q placeholder="Busca cartes" type=search name=q> 
	<button>Busca</button> 
</form>

<?php
	if(isset($_GET['q']) && $_GET['q']!='')
	{
		$q=mysql_real_escape_string($_GET['q']);
		echo "Resultats de la cerca '$q':";
	}
	else
	{
		$q='';
		echo "Totes les cartes en venta (".mysql_num_rows(mysql_query("SELECT 1 FROM ofertes"))."):";
	}
?><br>

<table> <tr><th>Carta<th>Venedor<th>Quantitat<th>Foil<th>Preu
<?php
	$sql=" 	SELECT 
			ofertes.carta AS carta,
			ofertes.id_jugador AS id_jugador,
			ofertes.quantitat AS quantitat,
			ofertes.foil AS foil,
			ofertes.preu AS preu,
			jugadors.nom AS venedor
		FROM 
			ofertes,jugadors
		WHERE
			ofertes.id_jugador=jugadors.id AND
			ofertes.carta LIKE '%$q%'
		ORDER BY
			ofertes.carta ASC, ofertes.preu ASC";
	$res=mysql_query($sql) or die('error');
	while($row=mysql_fetch_array($res))
	{
		$carta=mysql_real_escape_string($row['carta']);
		$id_jugador=$row['id_jugador'];
		$venedor=$row['venedor'];
		$quantitat=$row['quantitat'];
		$foil=$row['foil']? "Sí":"<span style=color:#ccc>No</span>";
		$preu=$row['preu'];
		echo "<tr>";
		echo "<td><a 
			onmousemove=\"mostraCover('$carta',event)\"
			onmouseout=amagaCover()
			>".str_replace('\\','',$carta)."</a>";
		echo "<td><a href=jugador.php?id=$id_jugador>$venedor</a>";
		echo "<td align=center>$quantitat";
		echo "<td align=center>$foil";
		echo "<td>$preu €";
	}
?>
</table>

<table id=venedors>
	<tr><th colspan=2>Venedors amb més cartes
	<tr><th>Nom<th>Articles en venta
	<?php
		$sql="SELECT * FROM jugadors";
		$res=mysql_query($sql);
		while($row=mysql_fetch_array($res))
		{
			$id_jugador=$row['id'];
			$nom=$row['nom'];
			//consulta el nombre d'articles en venta
			$a=mysql_num_rows(mysql_query("SELECT 1 FROM ofertes WHERE id_jugador=$id_jugador"));
			if($a>0)
			{
				echo "<tr>";
				echo "<td><a href=jugador.php?id=$id_jugador>$nom</a>";
				echo "<td align=center>$a";
			}
		}
	?>
</table>
<script>
	function ordena(id)
	//ordenar la taula per articles en venta
	{
		var i,j,t = document.getElementById(id)
		var files = t.rows.length-2
		//declarar array a ordenar i array a ordenat per despres comparar-los
		var ordenar = new Array(files)
		var ordenat = new Array(files)
		//contingut a ordenar
		for(i=0;i<files;i++)
		{
			//ordena per la columna 1
			ordenar[i]=t.rows[i+2].cells[1].innerHTML
			ordenat[i]=t.rows[i+2].cells[1].innerHTML
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
			trs[i]=t.rows[i+2].cloneNode(true)
		//elimina tota la taula
		for(i=0;i<files;i++) t.deleteRow(-1)
		//POSA LA TAULA EN ORDRE
		for(i=0;i<files;i++)
		{
			//seteja la primera columna amb el numero correcte
			//trs[ordre[i]].cells[0].innerHTML=i+1
			//
			t.appendChild(trs[ordre[i]])
		}
	}
	ordena('venedors')
</script>

<br><a href='javascript:infoVenta()'>Informació</a>
