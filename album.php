<?php
	//ENTRADA: id jugador
	//album visual de les cartes en venda del jugador id
	$id=$_GET['id'];
	include 'mysql.php';
	$res=mysql_query("SELECT nom FROM jugadors WHERE id=$id");
	$row=mysql_fetch_array($res);
	$nomJugador=$row['nom'];
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet type="text/css" href="estils.css" />
	<title>Pàgina de perfil</title>
	<style>
		img{margin:1px}
	</style>
	<script>
		function busca(carta,preu)
		//busca la imatge de la carta "carta"
		{
			var sol = new XMLHttpRequest()
			var url="http://api.mtgapi.com/v1/card/name/"+carta
			sol.open('GET',url,false)
			sol.send()
			//la api torna un array de cartes
			var resposta = JSON.parse(sol.responseText)
			var id=null,i=0
			while(i<resposta.length)
			{ 
				if(resposta[i].name.toUpperCase()==carta.toUpperCase() && resposta[i].id!==null)
				{
					id=resposta[i].id
					break;
				}
				i++ 
			}
			//busca imatge per id
			var src="http://gatherer.wizards.com/Handlers/Image.ashx?type=card&multiverseid="+id
			var img=document.createElement('img')
			img.setAttribute('onclick',"alert('"+preu+" euros')")
			img.src=src
			document.getElementById('album').appendChild(img)
		}
		function init()
		{
		<?php
			$sql="SELECT * FROM ofertes WHERE id_jugador=$id ORDER BY carta";
			$res=mysql_query($sql);
			while($row=mysql_fetch_array($res))
			{
				$carta=$row['carta'];
				$preu=$row['preu'];
				echo "busca(\"$carta\",$preu);";
			}
		?>
		}
	</script>
</head><body onload=init()><center>
<?php include 'header_sessio.php' ?>
<?php include 'cover.php' ?>
<?php include 'menu.php' ?>
<!--TITOL-->
<h2>Àlbum Visual - <?php echo $nomJugador ?></h2>
<h4>Click sobre una carta per veure el preu</h4>
<a href=jugador.php?id=<?php echo $id ?>>Enrere</a>
<div id=album></div>
<a href=jugador.php?id=<?php echo $id ?>>Enrere</a>
