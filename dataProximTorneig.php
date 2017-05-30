<?php
	$proxim="2017-06-18";
	$proximUnix=strtotime($proxim);
	$dataProximTorneig=date("d/m/Y",$proximUnix)."";
	$falten=ceil(($proximUnix-time())/86400);
?>
