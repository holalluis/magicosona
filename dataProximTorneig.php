<?php
  $proxim="2019-03-03";
  $proximUnix=strtotime($proxim);
  $dataProximTorneig=date("d/m/Y",$proximUnix);
  $falten=ceil(($proximUnix-time())/86400);
?>
