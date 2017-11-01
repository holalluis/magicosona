<?php
	//show lifetime points and season pw points
	function curl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 20);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$headers = array();
		$headers[] ="Accept:*/*";
		$headers[] ="Accept-Encoding:gzip,deflate,br";
		$headers[] ="Accept-Language:es-ES,es;q=0.8,ca;q=0.6,en;q=0.4,gl;q=0.2,pt;q=0.2,fr;q=0.2";
		$headers[] ="Cache-Control:no-cache";
		$headers[] ="Connection:keep-alive";
		$headers[] ="Content-Length:0";
		$headers[] ="Cookie:PlaneswalkerPointsSettings=0=6&lastviewed=8105340299;";
		$headers[] ="Host:www.wizards.com";
		$headers[] ="Origin:https://www.wizards.com";
		$headers[] ="Pragma:no-cache";
		$headers[] ="Referer:https://www.wizards.com/Magic/PlaneswalkerPoints";
		$headers[] ="User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36";
		$headers[] ="X-Requested-With:XMLHttpRequest";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result=curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	function pwPoints($dci) {
		$result=curl("https://www.wizards.com/Magic/PlaneswalkerPoints/JavaScript/GetPointsSummary/$dci");
		$json=json_decode($result);

		$data=$json->Data;

		//lifetime points i season points
		$ltPoints=$data[0]->Value;
		$sePoints=$data[10]->Value; //string
		$currLevl=$data[2]->Value;
		$proPoints=$data[10]->Value;

		//retalla string sePoints per tenir només el número de punts season
		$sePoints=preg_replace( "/\r|\n/", "",$sePoints);
		$pos_inici = strpos($sePoints,'<div class="SeasonPointsValuesValue">');
		$pos_final = strpos($sePoints,'</div>        </div>            <div class="SeasonRange">');
		$llargada = $pos_final-$pos_inici;
		$retallat = substr($sePoints,$pos_inici,$llargada)."</div>";
		$pos_inici = strpos($retallat,'>')+1;
		$pos_final = strpos($retallat,'</');
		$llargada = $pos_final-$pos_inici;
		$retallat = substr($retallat,$pos_inici,$llargada);
		$se=preg_replace("/\s/","",$retallat);

		$proPoints=preg_replace( "/\r|\n/", "",$proPoints);
		//print "<pre>".$proPoints."</pre>";
		//acabar TODO
		return "{\"lvl\":\"$currLevl\", \"lt\":\"$ltPoints\", \"se\":\"$se\"}";
	}

	if(isset($_GET['dci'])) echo pwPoints($_GET['dci']);
?>
