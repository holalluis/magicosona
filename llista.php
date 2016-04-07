<?php
	//Veure la llista id
	include 'mysql.php';

	//objecte resultat
	$resultat = new stdClass;

	//resultat id
	$resultat->id = isset($_GET['id']) ? $_GET['id'] : false;

	//comprova id
	if(!$resultat->id)die('id not set');

	//camps del resultat id
	$row=mysql_fetch_assoc(mysql_query("SELECT * FROM resultats WHERE id=$resultat->id"));
	$resultat->id_jugador      = $row['id_jugador'];
	$resultat->id_esdeveniment = $row['id_esdeveniment'];
	$resultat->punts           = $row['punts'];
	$resultat->baralla         = $row['baralla'];
	$resultat->llista          = $row['llista'];

	//obtenir noms de les coses
	$jugador      = current(mysql_fetch_assoc(mysql_query("SELECT nom FROM jugadors WHERE id=$resultat->id_jugador")));
	$esdeveniment = current(mysql_fetch_assoc(mysql_query("SELECT nom FROM esdeveniments WHERE id=$resultat->id_esdeveniment")));
	$punts        = $resultat->punts;
	$baralla      = current(mysql_fetch_assoc(mysql_query("SELECT nom FROM baralles WHERE id=$resultat->baralla")));
	$llista       = $resultat->llista;
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
	<link rel=stylesheet href="estils.css">
	<title>Magic Osona - Llista</title>
	<script>
		function show(nom)
		{
			var img=document.querySelector('#carta');
			img.src="http://gatherer.wizards.com/Handlers/Image.ashx?type=card&name="+nom;
		}

		function comptaBaralla(llista)
		{
			if(!llista) return false;

			var recompte = { main:0, side:0};

			['main','side'].forEach(function(part)
			{
				for(var carta in llista[part])
				{
					recompte[part] += llista[part][carta];
				}
			});
			return recompte;
		}

	</script>
</head><body><center>
<?php include 'menu.php' ?>

<?php
	echo "
	<h3>
		<a href=esdeveniment.php?id=$resultat->id_esdeveniment>$esdeveniment</a> &rsaquo;
		$baralla, <a href=jugador.php?id=$resultat->id_jugador>$jugador</a> 
		<span style=font-size:14px>($punts punts)</span>
	</h3>";

	/* $llista="
		{
			main:{
				'Mountain':20,
				'Lightning Bolt':4,
				'Goblin Guide':4,
				'Jace, Vryn\'s Prodigy':1,
				},
			side:{
				'Blood Moon':2,
			},
		} ";
	*/

	//comprova
	if($llista=="") 
	{
		$llista='false';
		echo("<h2>Llista no disponible</h2>");
	}

	//passa la llista a javascript
	echo "<script> var llista = $llista </script>";
?>

<!--llista-->
<div style="text-align:left;border:1px solid #eee;padding:0.5em;" class=inline>
	<script>
		if(llista)
		["main","side"].forEach(function(part)
		{
			document.write("<div class=inline style=max-width:50%><b id="+part+">"+part.toUpperCase()+"</b><ul>");
			for(var nom in llista[part])
			{
				var encoded = encodeURIComponent(nom).replace(/'/g, "%27");
				document.write("<li> <a href=#carta onclick=\"show('"+encoded+"');\" >"+llista[part][nom]+" "+nom+"</a>");
			}
			document.write("</div>");
		});

		//recompta el nombre de cartes
		var recompte = comptaBaralla(llista);

		document.querySelector('#main').innerHTML += " ("+recompte.main+")";
		document.querySelector('#side').innerHTML += " ("+recompte.side+")";
	</script>
</div>

<!--carta visible--> <img id=carta src="http://gatherer.wizards.com/handlers/image.ashx?type=card&name=no" style="width:200px;margin:0.2em"> </div>

<!--veure més baralles--><br><button style="margin:1em" onclick="<?php echo "window.location='baralla.php?id=$resultat->baralla'"?>">Veure més baralles <?php echo $baralla?></button>

<script>
	for(var nom in llista.main)	
	{
		var encoded = encodeURIComponent(nom).replace(/'/g, "%27");
		show(encoded)
		break;
	}
</script>

<?php
	//modificar llista
	if(isset($_COOKIE['admin']))
	{
		?>
		<div style='background:#efefef;padding:1em;margin-top:1em'>
			<h4>Actualitza llista</h4>
			<form action=controller/canviaLlista.php method=POST>
				<input name=id value=<?php echo $resultat->id?> type=hidden>
				<textarea name=llista rows=15 cols=40><?php echo $resultat->llista?></textarea>
				<button type=submit class=inline>Actualitza</button>
			</form>
		</div>
		<?php
	}
?>
