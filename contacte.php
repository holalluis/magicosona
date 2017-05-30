<?php include 'mysql.php' ?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Lliga Osonenca de Modern - Bases</title>
</head><body><center>
<?php include 'menu.php' ?>

<!--titol--><h2>Contacte</h2>

<?php
	//ENTRADA
	if(isset($_POST['nom']))
	{
		$nom	  = mysql_real_escape_string($_POST['nom']);
		$mail	  = mysql_real_escape_string($_POST['mail']);
		$missatge = mysql_real_escape_string($_POST['missatge']);

		mail('holalluis@gmail.com','Contacte formulari magicosona',"$nom\n$mail\n\n$missatge") or die('Error. Mail no enviat. Torna-ho a intentar més tard');
		die('Gràcies per contactar amb nosaltres. Ens posarem en contacte amb tu en el mínim temps possible.');
	}
?>

<div style=padding:0.5em>
	Pots contactar directament per
	<a target=_blank href="https://api.whatsapp.com/send?phone=34677626363">Whatsapp</a>
	o amb el següent formulari:
</div>

<!--formulari-->
<form method=POST style="margin:0 0.5em 0 0.5em">
	<table cellpadding=5 style=margin-top:0.5em>
		<style>
			form table input  {padding:0.5em 1em}
			form table button {padding:1em 2em}
			
		</style>
		<tr><th>Nom	<td><input name=nom placeholder=Nom required> *
		<tr><th>Mail	<td><input name=mail placeholder=Mail required> *
		<tr><th>Missatge<td><textarea style="width:400px;height:100px" name=missatge required placeholder="Escriu el teu missatge"></textarea> *
		<tr><th><td><button>Enviar</button>
	</table>
	<span style=font-size:11px>(*: camp obligatori)</span>
</form>

<script>
	//focus a nom
	document.getElementsByName('nom')[0].focus()
</script>
