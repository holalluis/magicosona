<?php

echo "<p>estic reconfigurant la web, vaig tenir problemes i he intentat reflotar-la amb petits invents però he decidit contractar un nou hosting per fer-ho bé. 
gràcies per la paciència, estarà llesta aviat. 
<br>lluís</p>
<hr>
";

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
