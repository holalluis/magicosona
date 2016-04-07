<?php

//comprova admin
if(!isset($_COOKIE['admin'])) die('sessio no iniciada');

include '../mysql.php';

//id llista
$id=$_POST['id'];
$llista=mysql_real_escape_string($_POST['llista']);

//nou nom de baralla
$sql="UPDATE resultats SET llista='$llista' WHERE id=$id";

mysql_query($sql) or die('error');

echo "tot ok";

header("Location: ".$_SERVER['HTTP_REFERER']);

?>
