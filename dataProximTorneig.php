<?php
  $proxim="2018-11-18";
  $proximUnix=strtotime($proxim);
  $dataProximTorneig=date("d/m/Y",$proximUnix);
  $falten=ceil(($proximUnix-time())/86400);
?>
