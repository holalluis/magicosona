<?php
	$proxim="2016-07-31";
	$proximUnix=strtotime($proxim);
	$dataProximTorneig=date("d/m/Y",$proximUnix)." (data confirmada)";
	$falten=floor(($proximUnix-time())/86400);
?>
