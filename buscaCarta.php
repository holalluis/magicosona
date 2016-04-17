<?php
	//Busca una carta dins el mkm
	$carta = isset($_GET['carta']) ? $_GET['carta'] : false;
	if($carta==false)die('Carta no especificada');

	include 'mysql.php';

	function curl($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 20);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$headers = array();
		$headers[] ="Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
		$headers[] ="Accept-Language:es-ES,es;q=0.8,ca;q=0.6,en;q=0.4,gl;q=0.2,pt;q=0.2,fr;q=0.2";
		$headers[] ="Cache-Control:no-cache";
		$headers[] ="Connection:keep-alive";
		$headers[] ="Host:www.magiccardmarket.eu";
		$headers[] ="Pragma:no-cache";
		$headers[] ="Referer:https://www.magiccardmarket.eu/?mainPage=browseUserProducts&idCategory=1&idUser=70688&editMode=&cardName=Felidar+Cub&idExpansion=&idRarity=&idLanguage=&condition_uneq=&condition=&isFoil=0&isSigned=0&isPlayset=0&isAltered=0&comments=&minPrice=&maxPrice=";
		$headers[] ="Upgrade-Insecure-Requests:1";
		$headers[] ="User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result=curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	function resultats($carta,$usuari)
	{
		$carta=urlencode($carta);
		$result=curl("https://www.magiccardmarket.eu/?mainPage=browseUserProducts&idCategory=1&idUser=$usuari&editMode=&cardName=$carta&idExpansion=&idRarity=&idLanguage=&condition_uneq=&condition=&isFoil=0&isSigned=0&isPlayset=0&isAltered=0&comments=&minPrice=&maxPrice=");
		$pos_inici = strpos($result,'<table class="MKMTable specimenTable MKMSortable">');
		$pos_final = strpos($result,'<span class="vAlignMiddle">Put selected in shopping cart: </span>');
		$llargada = $pos_final-$pos_inici;
		$retallat = substr($result,$pos_inici,$llargada);
		return $retallat;
	}
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
	<link rel=stylesheet href="estils.css">
	<title>Magic Osona - Busca Carta</title>
	<style>
		img.carta{width:50px;}
		table.MKMTable tfoot{display:none}
		table.MKMTable thead{display:none}
	</style>
</head><body><center>
<?php include_once("analytics.php") ?>
<!--carta gran-->
<img id=cartaGran style="top:0;left:20%;position:absolute;display:none;width:250px" onclick=this.style.display='none'>

<?php include'menu.php'?>

<script>
	function show(carta,e)
	{
		var img = document.querySelector('#cartaGran')
		img.style.display='inline';
		img.src="http://gatherer.wizards.com/handlers/image.ashx?type=card&name="+carta;
		img.style.left=(e.pageX-125)+"px"
		img.style.top=Math.max(0,e.pageY-250)+"px"
	}
</script>

<h2>Resultats cerca '<?php echo $carta?>' </h2>

<div class=inline style="border:1px solid #ccc;padding:0.5em;border-radius:1em;margin:0.5em">
	<form action=buscaCarta.php method=GET>
		Busca una carta:
		<input type=search name=carta placeholder="Cryptic Command" value="<?php echo $carta?>">
	</form>
</div>

<!--Resultats-->
<table>
	<tr><th>Venedor<th>Articles<th>Link
	<?php
		$sql="SELECT * FROM jugadors WHERE mkm!=''";
		$res=mysql_query($sql) or die('error');
		$comptador=0;
		while($row=mysql_fetch_assoc($res))
		{
			$id=$row['id'];
			$nom=$row['nom'];
			$mkm=$row['mkm'];
			$resultats = resultats($carta,$mkm);
			if($resultats)
			{
				echo "<tr><td style=vertical-align:top><a href=jugador.php?id=$id>$nom</a><td>$resultats";
				echo "<td> <a target=_blank href='https://www.magiccardmarket.eu/?mainPage=browseUserProducts&idCategory=1&idUser=$mkm&cardName=$carta'>Vés a MKM</a>";
				$comptador++;
			}
		}
		if($comptador==0)
			echo "<tr><td colspan=3>No hi ha resultats";
	?>
</table>

<script>
	//agafa totes les MKMTable
	var taules = document.querySelectorAll('table.MKMTable')
	for(var i=0;i<taules.length;i++)
	{
		var t = taules[i];
		t.deleteRow(0);
		t.deleteRow(-1);
		for(var j=0;j<t.rows.length;j++)
		{
			var fila = t.rows[j];
			fila.deleteCell(0);
			fila.deleteCell(0);
			fila.deleteCell(1);
			fila.deleteCell(1);
			fila.deleteCell(1);
			fila.deleteCell(1);
			fila.deleteCell(1);
			fila.deleteCell(1);
			fila.deleteCell(1);
			fila.deleteCell(1);
			fila.deleteCell(1);
			fila.deleteCell(1);
			fila.deleteCell(3);
			var nomCarta = fila.cells[0].textContent;
			var encoded = encodeURIComponent(nomCarta).replace(/'/g, "%27");
			fila.insertCell(0).innerHTML="<img class=carta onclick=\"show('"+encoded+"',event)\" src='http://gatherer.wizards.com/handlers/image.ashx?type=card&name="+encoded+"'>";
			var link = fila.cells[1].childNodes[1].childNodes[0].childNodes[0].href="buscaCarta.php?carta="+encoded;
		}
	}
</script>
