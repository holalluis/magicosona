<?php

error_reporting(E_ALL);

if(in_array($_SERVER['SERVER_NAME'],array('localhost'),true))
{
	$mysql=mysqli_connect("127.0.0.1","root","","magicosona") 
	or 
	die(mysqli_error($mysql));
}
else
{
	$mysql=mysqli_connect("127.0.0.1","root","Bol729sh","magicosona") 
	or 
	die(mysqli_error($mysql));
}

//debugging
//var_dump($mysql);

?>
