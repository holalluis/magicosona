<?php include'mysql.php'?>
<!doctype html><html><head>
	<?php include'imports.php'?>
	<title>Contacte</title>
	<style>
		#navbar [contacte]{
			background:#fefefe;
			border-bottom-color:#395693;
		} 
	</style>
</head><body><center>
<?php include'menu.php'?>
<h2>Contacte</h2>

<?php
	//ENTRADA
	/*
	if(isset($_POST['nom'])) {
		$nom	    = mysqli_real_escape_string($_POST['nom']);
		$mail	    = mysqli_real_escape_string($_POST['mail']);
		$missatge = mysqli_real_escape_string($_POST['missatge']);
		mail('holalluis@gmail.com','Contacte formulari magicosona',"$nom\n$mail\n\n$missatge") or die('Error. Mail no enviat. Torna-ho a intentar més tard');
		die('Gràcies per contactar amb nosaltres. Ens posarem en contacte amb tu en el mínim temps possible.');
	}
	*/
?>

<!--nota-->
<div style=padding:0.5em id=nota>
	<style>
		#nota .item {
			margin:10px 0;
		}
	</style>
	Contacta directament al whatsapp amb el següent enllaç:
	<div class=item>
		<a target=_blank style=font-size:23px href="https://api.whatsapp.com/send?phone=34677626363">
			Whatsapp (677626363)
		</a>
	</div>
	o per mail: 
	<div class=item>
		<a target=_blank style=font-size:23px href="mailto:holalluis@gmail.com">
			holalluis@gmail.com
		</a>
	</div>
	<!--
	o amb el següent formulari:
	-->
</div>

<!--formulari
<form method=POST>
	<table style=margin:auto>
		<style>
			form table input {
				padding:0.4em;
				border:1px solid #ccc;
			}
			form table button {
				padding:1em 2em;
			}
			form textarea {
				border:1px solid #ccc;
				padding:0.4em;
			}
		</style>
		<tr><th>Nom	<td><input name=nom placeholder=Nom required> *
		<tr><th>Mail	<td><input name=mail placeholder=Mail required> *
		<tr><th>Missatge<td><textarea name=missatge required placeholder="Escriu el teu missatge"></textarea> *
		<tr><th><td><button>Enviar</button>
	</table>
	<span style=font-size:11px>(*: camp obligatori)</span>
</form>

<script>
	//focus a nom
	document.getElementsByName('nom')[0].focus();
</script>
-->
