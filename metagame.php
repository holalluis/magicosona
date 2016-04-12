<?php include 'mysql.php' ?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet type="text/css" href="estils.css" />
	<style> #metagame th,#metagame td {border-left:none;border-right:none} </style>
	<title>Lliga Osonenca de Modern - Metagame</title>
	<script>
		function ordena(id, columna_a_ordenar)
		{
			//TAULA
			var t = document.getElementById(id)
			//nombre de files
			var files = t.rows.length-1
			//nombre de columnes
			var columnes=t.rows[0].cells.length-1
			//array a ordenar i array ordenat per despres comparar-los
			var ordenar = new Array(files)
			var ordenat = new Array(files)
			//contingut a ordenar
			for(var i=0;i<files;i++)
			{
				ordenar[i]=t.rows[i+1].cells[columna_a_ordenar].innerHTML
				ordenat[i]=t.rows[i+1].cells[columna_a_ordenar].innerHTML
			}
			//ordena un dels dos arrays
			ordenat.sort(function(a,b){return b-a})
			//compara els dos arrays per trobar l'ordre correcte
			var ordre=new Array(files)
			for(var i=0;i<files;i++)
			{
				for(var j=0;j<files;j++)
				{
					if(ordenar[j]==ordenat[i])
					{
						ordre[i]=j
						break;
					}
				}
				//treu l'index que has trobat
				ordenar[ordre[i]]=""
			}
			//ara ja tenim l'array ordre fet
			// comencem fent una copia de les files i esborrant la taula
			var trs=new Array(files)
			//copia tots els <tr>
			for(i=0;i<files;i++)
				trs[i]=t.rows[i+1].cloneNode(true)
			//elimina tota la taula
			for(i=0;i<files;i++)
				t.deleteRow(-1)
			//POSA les files en ordre segons l'array ordre calcula prèviament
			for(i=0;i<files;i++)
			{
				t.appendChild(trs[ordre[i]])
			}
		}
	</script>
</head><body onload="ordena('metagame',1)"><center>
<?php include 'menu.php' ?>

<h2>Metagame</h2>

<table id=metagame>
<tr><th>Baralla<th>Aparicions durant la lliga
<?php
	//guarda en un array les diferents baralles
	$sql="SELECT DISTINCT baralla FROM resultats ORDER BY baralla";
	$res=mysql_query($sql);
	$i=0;
	while($row=mysql_fetch_assoc($res))
	{
		if($row['baralla']=='') continue;
		$baralla[$i]=$row['baralla'];
		$i++;
	}

	$n=count($baralla);

	for($i=0; $i<$n; $i++)
	{
		$sql="SELECT COUNT(id) FROM resultats WHERE baralla='".$baralla[$i]."'";
		$res=mysql_query($sql);
		$row=mysql_fetch_assoc($res);
		$numero=$row['COUNT(id)'];

		$sql="SELECT nom FROM baralles WHERE id='".$baralla[$i]."'";
		$res=mysql_query($sql);
		$row=mysql_fetch_assoc($res);
		$nom=$row['nom'];
		$id=$baralla[$i];

		echo "<tr><td><a href=baralla.php?id=$id>$nom</a><td>$numero";
	}
?>
</table>
