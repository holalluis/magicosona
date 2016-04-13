<?php
	//Busca una carta dins el mkm
	//escriu true o false al final de tot
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

	$sql="SELECT mkm,nom FROM jugadors WHERE mkm!=''";
	$res=mysql_query($sql) or die('error');
	$comptador=0;
	while($row=mysql_fetch_assoc($res))
	{
		$mkm=$row['mkm'];
		$nom=$row['nom'];
		$resultats=resultats($carta,$mkm);
		if($resultats) 
		{
			echo "- $nom<br>";
			$comptador++;
		}
	}
	if($comptador==0)die("false");
?>
