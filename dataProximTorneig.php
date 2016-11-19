<?php
	$proxim="2016-11-20";
	$proximUnix=strtotime($proxim);
	$dataProximTorneig=date("d/m/Y",$proximUnix)." (confirmat)";
	$falten=ceil(($proximUnix-time())/86400);
?>
