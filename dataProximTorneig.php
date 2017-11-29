<?php
	$proxim="2017-12-17";
	$proximUnix=strtotime($proxim);
	$dataProximTorneig=date("d/m/Y",$proximUnix)."";
	$falten=ceil(($proximUnix-time())/86400);
?>
