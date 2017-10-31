<?php

if(!isset($_COOKIE['admin']))
	die('sessio no iniciada');

include '../mysql.php';

//entrada
$nom=mysqli_real_escape_string($_GET['nom']);
$data=$_GET['data'];

if($nom=="" or $data=="")
{
	die("<script>alert('Hi ha el nom o la data en blanc');history.go(-1)</script>");
}

//crea un nou esdeveniment
$sql="INSERT INTO esdeveniments (nom,data) VALUES ('$nom','$data')";
$mysql->query($sql) or die('error');

//troba la id del nou esdeveniment i guarda-la a la variable $esd
$sql="SELECT MAX(id) FROM esdeveniments";
$res=$mysql->query($sql);
$row=mysqli_fetch_array($res);
$esd=$row['MAX(id)'];

//agafa els punts de tots els jugadors i inserta'ls a resultats
$sql="SELECT * FROM jugadors";
$res=$mysql->query($sql);
while($row=mysqli_fetch_array($res))
{
	//bucle per introduir resultats
	$id=$row['id'];
	$punts=$_GET["punts_jugador_$id"];

	//TODO
	$posicio=$_GET["posicio_jugador_$id"]; //possible manera d'implementar la posicio
	switch($posicio)
	{
		case 1: $punts+=6; break; //1r
		case 2: $punts+=3; break; //2n
		case 3: $punts+=2; break; //3r-4rt
		case 4: $punts+=1; break; //5è-8è
	}

	//si es primer del suis suma un punt extra
	$primerDelSuis=$_GET["is_primer_suis_jugador_$id"];
	if($primerDelSuis=='on')
		$punts++;

	if($punts>0)
	{
		$sql="INSERT INTO resultats (id_jugador,id_esdeveniment,punts) VALUES ('$id','$esd','$punts')";
		$mysql->query($sql) or die('error');
	}
}

echo 'tot insertat ok';

header("Location: ../esdeveniment.php?id=$esd");

?>
