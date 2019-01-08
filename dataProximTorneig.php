<?php
  $proxim="2019-01-27";
  $proximUnix=strtotime($proxim);
  $dataProximTorneig=date("d/m/Y",$proximUnix);
  $falten=ceil(($proximUnix-time())/86400);
?>
