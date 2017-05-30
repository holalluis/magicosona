<?php
	setcookie("admin","",time()-86400,"/") or die('error');
	header('Location: '.$_SERVER['HTTP_REFERER']);
?>
