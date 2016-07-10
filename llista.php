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
	<?php include 'imports.php' ?>
	<title>Magic Osona - Llista</title>
	<style>
		div.carta{
			padding:0.1em;
			border-radius:0.5em;
			transition:all 0.5s;
			margin-left:3px;
		}
		div.carta:hover {
			background:gold;
		}
		button#buscar
		{
			max-width:14em;
			margin:0.2em
			text-align:left;
		}
		h3{margin-bottom:1.5em}
	</style>

	<script>
		function show(nom)
		{
			var img=document.querySelector('#carta');
			img.src="http://gatherer.wizards.com/Handlers/Image.ashx?type=card&name="+nom;
			img.onclick=function(){window.open('http://magiccards.info/query?q='+nom)}
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
		function exportarTxt(llista)
		{
			var txt = "";
			for(var carta in llista.main)
				txt+=llista.main[carta]+" "+carta+'\r\n';
			for(var carta in llista.side)
				txt+="SB: "+llista.side[carta]+" "+carta+'\r\n';
			//genera arxiu
			var arxiu = "data:text/txt;charset=utf-8,"+encodeURI(txt);
			window.location=arxiu;
		}
	</script>
</head><body><center>
<?php include_once("analytics.php") ?>
<?php include 'menu.php' ?>

<?php
	echo "
	<h3>
		<a href=esdeveniment.php?id=$resultat->id_esdeveniment>$esdeveniment</a> &rsaquo;
		$baralla, <a href=jugador.php?id=$resultat->id_jugador>$jugador</a> 
		<span style=font-size:14px>($punts punts)</span>
		<button onclick=\"window.location='baralla.php?id=$resultat->baralla'\">Veure més baralles $baralla</button>
	</h3>";

	//comprova llista buida
	if($llista=="") 
	{
		echo("<h2>Llista no disponible</h2>");
		$llista='false'; //per passar a javascript
	}

	//passa la llista a javascript
	echo "<script> var llista = $llista </script>";
?>

<!--llista-->
<div style="text-align:left;border-radius:0.5em;border:1px solid #eee;padding:0.5em;" class=inline>
	<script>
		if(llista)
		{
			["main","side"].forEach(function(part)
			{
				document.write("<div class=inline style='max-width:50%'><b id="+part+">"+part.toUpperCase()+"</b>");
				for(var nom in llista[part])
				{
					var encoded = encodeURIComponent(nom).replace(/'/g, "%27");
					document.write("<div class=carta>"+llista[part][nom]+
						" <a href=# onclick=\"show('"+encoded+"');\" >"+nom+"</a></div>");
				}
				document.write("</div>");
			});
			//recompta el nombre de cartes
			var recompte = comptaBaralla(llista);
			document.querySelector('#main').innerHTML += " ("+recompte.main+")";
			document.querySelector('#side').innerHTML += " ("+recompte.side+")";
		}
	</script>
</div>

<!--carta visible--><div class=inline> 
	<img id=carta src="http://gatherer.wizards.com/handlers/image.ashx?type=card&name=no" style="width:95%;margin:0.5em"> 
	<br>
	<!--exporta--><button onclick=exportarTxt(llista)>Exporta TXT</button>
</div>


<script>
	//posa el primer element de la llista visible
	(function(){
		for(var nom in llista.main)	
		{
			var encoded = encodeURIComponent(nom).replace(/'/g, "%27");
			show(encoded)
			break;
		}
	})();
</script>

<?php
	//modificar llista
	if(isset($_COOKIE['admin']) || $resultat->id_jugador==$_COOKIE['jugador'])
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
