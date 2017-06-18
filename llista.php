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
		#carta {
			width:223px;
			height:310px;
		}
		div.carta{
			padding:0.05em;
			border-radius:0.5em;
			margin-left:3px;
			cursor:default;
			color:#212121;
		}
		div.carta span.nom:hover {
			color:gold;
		}
		h3{margin-bottom:0.5em}
	</style>

	<script>
		function show(nom) {
			var img=document.querySelector('#carta');
			img.src=""
			img.src="http://gatherer.wizards.com/Handlers/Image.ashx?type=card&name="+nom
			img.onclick=function(){window.open('http://magiccards.info/query?q='+nom)}
		}

		function comptaBaralla(llista) {
			if(!llista) return false;

			var recompte = { main:0, side:0};

			['main','side'].forEach(function(part) {
				for(var carta in llista[part])
				{
					recompte[part] += llista[part][carta];
				}
			});
			return recompte;
		}

		function exportarTxt(llista) {
			var txt="";

			for(var carta in llista.main) {txt+=llista.main[carta]+" "+carta+'\r\n';}

			for(var carta in llista.side) {txt+="SB: "+llista.side[carta]+" "+carta+'\r\n';}

			//genera arxiu
			var arxiu = "data:text/txt;charset=utf-8,"+encodeURI(txt);

			window.open(arxiu);
		}
	</script>
</head><body><center>
<?php include 'menu.php' ?>

<?php
	echo "
	<h3>
		<a href=esdeveniment.php?id=$resultat->id_esdeveniment>Torneig $esdeveniment</a> &rsaquo;
		$baralla, <a href=jugador.php?id=$resultat->id_jugador>$jugador</a> 
		<span style=font-size:14px>($punts punts)</span>
	</h3>";

	//comprova llista buida
	if($llista=="") 
	{
		echo("<h2>Llista no disponible (<a href=contacte.php>si la tens, envia-la! moltes gràcies</a>)</h2>");
		$llista='false'; //per passar a javascript
	}

	//passa la llista a javascript
	echo "<script> var llista = $llista </script>";
?>

<div id=root class=flex>
<?php
	if($llista!='false') { 
		?>
		<!--llista-->
		<div class=flex style="max-width:50%;text-align:left;border-radius:0.5em;border:1px solid #ccc;padding:0.5em;">
			<script>
				if(llista)
				{
					["main","side"].forEach(function(part)
					{
						document.write("<div style='max-width:50%'><b id="+part+">"+part.toUpperCase()+"</b>");
						for(var nom in llista[part])
						{
							var encoded = encodeURIComponent(nom).replace(/'/g, "%27");
							document.write("<div class=carta>"+llista[part][nom]+
								" <span class=nom onmouseover=\"show('"+encoded+"');\" >"+nom+"</span></div>");
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

		<!--carta visible-->
		<div style="max-width:40%;text-align:left"> 
			<img id=carta src="http://gatherer.wizards.com/handlers/image.ashx?type=card&name=no" style="margin:0 0.5em"> 
			<!--exporta-->
			<div>
				<button onclick=exportarTxt(llista) 
					      style="margin:1em 1em;padding:0.5em 1em">Exporta TXT</button> <br>
				<button style="margin:0em 1em;padding:0.5em 1em" onclick="window.location='baralla.php?id=<?php echo $resultat->baralla?>'"
				>Veure més baralles <?php echo $baralla?></button>
			</div>
		</div>
		<script>
			//posa la primera carta visible
			(function(){
				for(var nom in llista.main)	{
					var encoded=encodeURIComponent(nom).replace(/'/g, "%27");
					show(encoded);
					break;
				}
			})();

			//preload imatges a background
			window.onload=function(){
				[llista.main,llista.side].forEach(obj=>{
					for(var nom in obj)	{
						var encoded=encodeURIComponent(nom).replace(/'/g, "%27");
						new Image().src="http://gatherer.wizards.com/Handlers/Image.ashx?type=card&name="+encoded;
					}
				});
			};
		</script>
		<?php 
	}
?>
</div>

<?php
	//modificar llista
	if(isset($_COOKIE['admin']) || isset($_COOKIE['jugador']) && $resultat->id_jugador==$_COOKIE['jugador'])
	{
		?>
		<div style='background:#efefef;padding:1em;'>
			<h4>Envia llista</h4>
			<div>
<textarea name=llista rows=15 cols=60 placeholder="Enganxa la llista aquí">
20 Mountain
40 Lightning Bolt
SB: 15 Goblin Guide
</textarea>
				<div> <button onclick=processaBaralla()>Actualitza</button> </div>
				<script>
					function processaBaralla(){
						var str=document.querySelector('textarea[name=llista]').value;
						var json=JSON.stringify(parserBaralla(str));
						var sol=new XMLHttpRequest();
						sol.open('POST','controller/canviaLlista',true);
						sol.setRequestHeader("Content-type","application/x-www-form-urlencoded");
						sol.onreadystatechange=function () {
							if(sol.readyState===XMLHttpRequest.DONE && sol.status===200){
								alert(sol.responseText);
								window.location.reload();
							}
						};
						sol.send("id=<?php echo $resultat->id?>&llista="+encodeURIComponent(json));
					}
					//converteix text a json
					function parserBaralla(str) {
						//baralla
						var json={main:{},side:{}};
						//separa per linies
						var linies=str.split('\n').filter(function(n){return (n!="" && n!=" " && n!="	")});
						linies.forEach(function(linia){
							var tokens=linia.split(" ");
							if(tokens[0]=="SB:") {
								var qua=parseInt(tokens[1]);
								var nom=tokens.slice(2).join(" ");
								json.side[nom]=qua;
							}
							else {
								var qua=parseInt(tokens[0]);
								var nom=tokens.slice(1).join(" ");
								json.main[nom]=qua;
							}
						});
						return json;
						/*var llista=""+
							"4 Monastery Swiftspear\n"+
							"4 Skullcrack\n"+
							"SB: 2 Wear // Tear\n"+
							*/
						//#test:console.log(parserBaralla(llista));
					}
				</script>
			</div>
		</div>
		<?php
	}
?>
