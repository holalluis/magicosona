<?php
	$proxim="2017-10-01";
	$proximUnix=strtotime($proxim);
	$dataProximTorneig=date("d/m/Y",$proximUnix)."";
	$falten=ceil(($proximUnix-time())/86400);
?>
