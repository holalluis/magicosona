<?php
	$proxim="2016-09-04";
	$proximUnix=strtotime($proxim);
	$dataProximTorneig=date("d/m/Y",$proximUnix)." (provisional)";
	$falten=ceil(($proximUnix-time())/86400);
?>
