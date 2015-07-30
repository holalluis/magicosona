<?php include 'mysql.php' ?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<link rel=stylesheet type="text/css" href="estils.css" />
	<title>Lliga Osonenca de Modern - Bases</title>
</head><body><center>
<?php include 'header_sessio.php' ?>
<?php include 'menu.php' ?>

<h2>Contacte</h2>

<?php
	//ENTRADA
	if(isset($_POST['nom']))
	{
		$nom	  = mysql_real_escape_string($_POST['nom']);
		$mail	  = mysql_real_escape_string($_POST['mail']);
		$tel	  = mysql_real_escape_string($_POST['tel']);
		$missatge = mysql_real_escape_string($_POST['missatge']);

		mail('holalluis@gmail.com','Contacte formulari magicosona',"$nom\n$mail\n$tel\n\n$missatge") or die('Error. Mail no enviat. Torna-ho a intentar');
		die('Gràcies per contactar amb nosaltres. Ens posarem en contacte amb tu en el mínim temps possible.');
	}
?>

<form method=POST>
<table cellpadding=5>
	<tr><th>Nom	<td><input name=nom placeholder=Nom required> *
	<tr><th>Mail	<td><input name=mail placeholder=Mail required> *
	<tr><th>Telèfon	<td><input name=tel placeholder=Telèfon>
	<tr><th>Missatge<td><textarea rows=4 cols=50 name=missatge required>Hola, vull inscriure'm a la Lliga Osonenca de Modern</textarea> *
	<tr><th><td align=right><button>Enviar</button>
</table>
</form>
(*: camp obligatori)

</html>
<script>
	//focus a nom
	document.getElementsByName('nom')[0].focus()
</script>
