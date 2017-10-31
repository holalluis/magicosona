<?php

echo $_SERVER['SERVER_NAME'];
echo "<p>estic configurant la web, vaig tenir problemes amb el hosting anterior i ara n'he contractat un de nou. gràcies. <br>lluís</p>";

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

var_dump($mysql);

?>
