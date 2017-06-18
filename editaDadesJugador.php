<?php
	$id=$_GET['id'];
	if($id=="")die('error: id jugador not set');

	//si no admin o si !jugador o cookie==id, atura't
	if(!isset($_COOKIE['admin']))
	{
		if(!isset($_COOKIE['jugador'])) die('no permès');

		if($_COOKIE['jugador']!=$id) die('no permès');
	}
	include 'mysql.php';
?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Pàgina de perfil - Editar</title>
	<script>
		function actualitza(camp,nouValor,btn) {
			//si nouValor val "0" ò "": you can't get any more pretty than this :)
			if(['0',''].indexOf(nouValor)+1){alert("Valor no vàlid");return}

			//nou ajax
			var sol=new XMLHttpRequest()
			sol.open('POST','controller/editaJugador?id=<?php echo $id?>',true)
			sol.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			sol.onreadystatechange=function() {
			  if(sol.readyState==4 && sol.status==200) alert(sol.responseText);
			}
			sol.send("camp="+camp+"&nouValor="+nouValor);
		}

		function nouPass(btn)
		{
			var cur=document.querySelector('#curPass').value
			var nou=document.querySelector('#nouPass').value
			var rep=document.querySelector('#repPass').value

			//comprova
			if(nou!=rep) {
				alert("Els passwords no coincideixen");return;
			}

			//nou ajax
			var sol=new XMLHttpRequest()
			sol.open('POST','controller/canviaPass',true)
			sol.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			sol.onreadystatechange=function() {
				if(sol.readyState==4 && sol.status==200) alert(sol.responseText)
			}
			sol.send("id=<?php echo $id?>&cur="+cur+"&nou="+nou);
		}
	</script>
</head><body><center>
<?php include 'menu.php' ?>

<h2>Modificar dades del jugador</h2>

<?php
	//GET JUGADOR
	$sql="SELECT * FROM jugadors WHERE id=$id";
	$res=mysql_query($sql);
	$row=mysql_fetch_assoc($res);
	$nom=$row['nom'];
	$mkm=$row['mkm'];
	$dci=$row['dci'] ? $row['dci'] : "";
?>

<div>
	<a href=jugador.php?id=<?php echo $id?>>&larr; Enrere</a>
</div>

<!--FORMULARI-->
<table id=dades>
	<style>
		#dades {margin-top:0.5em}
		#dades td, #dades th{
			padding:1em;
		}
		#dades input{padding:0.5em}
	</style>
	<tr>
		<th>Nom
			<td><input id=nouNom value="<?php echo $nom?>" autocomplete=off>
			<button onclick=actualitza('nom',document.querySelector('#nouNom').value,this)>Guarda</button>
	<tr>
		<th>DCI
		<td><input id=nouDci value="<?php echo $dci?>" placeholder="nº DCI" autocomplete=off>
		<button onclick=actualitza('dci',document.querySelector('#nouDci').value,this)>Guarda</button>
	<tr>
		<th>MKM id number
		<td><input id=nouMkm value="<?php echo $mkm?>" autocomplete=off>
		<button onclick=actualitza('mkm',document.querySelector('#nouMkm').value,this)>Guarda</button>
	<tr>
		<th>Modificar Password
			<td>
				<input id=curPass type=password placeholder="Actual" autocomplete=off>
				<br>
				<input id=nouPass type=password placeholder="Nou" autocomplete=off>
				<br>
				<input id=repPass type=password placeholder="Repeteix nou" autocomplete=off>
		<button onclick=nouPass(this)>Guarda</button>
</table>
