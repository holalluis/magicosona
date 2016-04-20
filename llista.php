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
		}
		div.carta:hover {
			background:gold;
		}
	</style>
	<script>
		function show(nom)
		{
			var img=document.querySelector('#carta');
			img.src="http://gatherer.wizards.com/Handlers/Image.ashx?type=card&name="+nom;
			img.onclick=function(){window.open('http://magiccards.info/query?q='+nom)}

			//mostra el boto buscar
			var boto = document.querySelector('#buscar');
			boto.style.display="block";
			boto.innerHTML="Clica sobre el nom per buscar "+decodeURIComponent(nom)+" en venda";
			boto.onclick=function(){window.location='buscaCarta.php?carta='+nom}
			boto.setAttribute('disabled',true)
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

		function cartaDisponible(carta)
		{
			var nom = decodeURIComponent(carta);
			var boto = document.getElementById('buscar')
			boto.innerHTML="Buscant "+nom+" en venda...";
			var sol = new XMLHttpRequest();
			sol.open('GET','cartaDisponible.php?carta='+carta,true)
			sol.onreadystatechange=function() 
			{
			    if(sol.readyState==4 && sol.status==200)
				{
					var text = sol.responseText!="false" ? nom+" disponible!<br> "+sol.responseText : nom+" no disponible entre els jugadors";
					console.log(sol.responseText);
					boto.innerHTML=text;
					if(sol.responseText!="false") 
						boto.removeAttribute('disabled');
				}
			};
			sol.send();
		}
	</script>
</head><body><center>
<?php include_once("analytics.php") ?>
<?php include 'menu.php' ?>

<?php
	echo "
	<h3>
		<a href=torneigs.php>Torneigs</a> &rsaquo;
		<a href=esdeveniment.php?id=$resultat->id_esdeveniment>$esdeveniment</a> &rsaquo;
		$baralla, <a href=jugador.php?id=$resultat->id_jugador>$jugador</a> 
		<span style=font-size:14px>($punts punts)</span>
		<button onclick=\"window.location='baralla.php?id=$resultat->baralla'\">Veure més baralles $baralla</button>
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
<div style="font-size:12px;text-align:left;border-radius:0.5em;border:1px solid #eee;padding:0.5em;" class=inline>
	<script>
		if(llista)
		{
			["main","side"].forEach(function(part)
			{
				document.write("<div class=inline style='max-width:50%'><b id="+part+">"+part.toUpperCase()+"</b>");
				for(var nom in llista[part])
				{
					var encoded = encodeURIComponent(nom).replace(/'/g, "%27");
					document.write("<div class=carta style=margin-left:3px>"+llista[part][nom]+" <a href=#carta onclick=\"cartaDisponible('"+encoded+"')\" onmouseover=\"show('"+encoded+"');\" >"+nom+"</a></div>");
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
	<button disabled id=buscar style="max-width:14em;display:none;margin:0.2em">Busca</button>
</div>

<script>
	//posa el primer element de la llista visible
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
