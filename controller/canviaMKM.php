<?php

//comprova admin
if(!isset($_COOKIE['admin'])) die('sessio no iniciada');

include '../mysql.php';

//entrada
$id=$_POST['id'];
$mkm=mysql_real_escape_string($_POST['mkm']);

//Sql
$sql="UPDATE jugadors SET mkm='$mkm' WHERE id=$id";
mysql_query($sql) or die('error');

//resultat
echo "tot ok";

//torna
header("Location: ".$_SERVER['HTTP_REFERER']);

?>
