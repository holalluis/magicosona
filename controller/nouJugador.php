<?php

if(!isset($_COOKIE['admin']))
	die('sessio no iniciada');

include '../mysql.php';
$nom=mysql_real_escape_string($_GET['nom']);
$dci=mysql_real_escape_string($_GET['dci']);

//nou jugador
$sql="INSERT INTO jugadors (nom,dci) VALUES ('$nom','$dci')";
mysql_query($sql) or die('error');
echo 'nou jugador ok';

//troba la id del nou jugador insertat per generar la seva contrasenya
$sql="SELECT MAX(id) FROM jugadors";
$res=mysql_query($sql) or die('error');
$row=mysql_fetch_array($res);
$id=$row['MAX(id)'];

//genera la nova contrasenya
$p1=$id-1;
$p3=$id+1;
$sql="UPDATE jugadors SET pass='".$p1.$id.$p3."' WHERE id=$id";
mysql_query($sql) or die('error');
echo 'nou password ok';
header("Location: ../jugador.php?id=$id");

?>
