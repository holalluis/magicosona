<?php include 'mysql.php' ?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Lliga Osonenca de Modern - Bases</title>
	<style>
		ul{list-style:none}
		hr{margin-top:0.5em}
	</style>
</head><body><center>
<?php include_once("analytics.php") ?>
<?php include 'menu.php' ?>

<h2>Bases — Normes de la lliga</h2>

<div style=text-align:left>
<ul>
	<li><b>Informació general</b>
		<ul>
			<li>L'entrada està oberta a tothom
			<li>El format és <a href="http://magic.wizards.com/en/gameinfo/gameplay/formats/modern">Modern</a>.
			<li>Ubicació: Club Billar Vic, <a href="https://www.google.es/maps/place/Carrer+de+l'Arquebisbe+Alemany,+24,+08500+Vic,+Barcelona/@41.9319626,2.2490315,17z/data=!3m1!4b1!4m2!3m1!1s0x12a5271b7b0f0561:0x9d4451d075aba9b1">C/Arquebisbe Alemany 24-26, Vic</a>
			<li>Quan: Tercer diumenge de cada mes (normalment).
			<li>Inscripcions: 9:00h — 10:00h.
			<li>Inici del torneig: 10:00h 
			<li>Preu: 7€. 5€ van pels premis del mateix dia, i 2€ s'acumulen pels premis de la final.
			<li>Es faran uns 5 – 6 esdeveniments, més una final. 
			<li>És obligatori portar la llista de la baralla jugada (nom jugador, nom de la baralla, cartes de la baralla d’inici i de banqueta).
		</ul>
		<hr>
	<br>
	<li><b>Rondes</b>
		<ul>
			<li>Cada torneig consistirà de dues parts: suís i top 8.
			<li>Suís: es faran 4, 5 ò 6 rondes de suís amb una duració de 45 minuts cadascuna. 
			El número de rondes es farà segons el nombre de participants.
			<li>Quan s’acabi el temps de ronda, es deixarà als jugadors 5 torns més per acabar la partida. 
			Després començarà la ronda següent.
		</ul>
		<hr>
	<br>
	<li><b>Puntuació</b>
		<ul>
			<li>Durant les rondes del suís, el guanyador rebrà 3 punts (el millor de 3 partides). 
			Empat: 1 punt, derrota: 0 punts.
			<li>La puntuació que es rebrà per la lliga serà segons el punts acumulats durant el suís.
			<li>Puntuació extra:
				<ul>
					<li>El primer classificat del suís rebrà un punt extra, i a més a més, depenent de la posició en el top:<br>
						<table class=inline>
							<tr><th>#<th colspan=2>En cas de TOP 8
							<tr><td>1r:<td>  1 + 1 + 1 + 3<td>= 6 punts
							<tr><td>2n:<td>  1 + 1 + 1    <td>= 3 punts
							<tr><td>3r:<td>  1 + 1        <td>= 2 punts
							<tr><td>4t:<td>  1 + 1        <td>= 2 punts
							<tr><td>5è:<td>  1						<td>= 1 punt
							<tr><td>6è:<td>  1						<td>= 1 punt
							<tr><td>7è:<td>  1						<td>= 1 punt
							<tr><td>8è:<td>  1						<td>= 1 punt
						</table>
						<table class=inline>
							<tr><th>#<th colspan=2>En cas de TOP 4
							<tr><td>1r:<td>  1 + 1 + 2  <td>= 4 punts
							<tr><td>2n:<td>  1 + 1			<td>= 2 punts
							<tr><td>3r:<td>  1					<td>= 1 punt
							<tr><td>4t:<td>  1					<td>= 1 punt
						</table>
				</ul>
		</ul>
		<hr>
	<br>
	<li><b>Top 8</b>
		<ul>
			<li>Després de les rondes de suís, els 8 jugadors amb més punts entraran dins del top 8, que es farà per eliminatòries, on no hi haurà límit de temps.
			<li>Els encreuaments es faran de la següent manera:
				<ul>
					<li>1r vs 8è
					<li>2n vs 7è
					<li>3r vs 6è
					<li>4rt vs 5è
					<li>El jugador més ben classificat decidirà qui comença.
				</ul>
		</ul>
		<hr>
	<br>
	<li><b>La final</b>
		<ul>
			<li>Un cop finalitzats tots els esdeveniments de la lliga, els 16 jugadors amb més puntuació estaran classificats per la final.
			<li>La final consistirà en 5 rondes de suís i top 8. S’aplicaran les mateixes normes explicades anteriorment.
		</ul>
		<hr>
	<br>
	<li><b>Desempats</b>
		<ul>
			<li>En cas d’acabar la lliga i que 2 o més jugadors/es estiguin empatats a punts, els criteris de desempats per ordre d’importància són:
			<li>1. El jugador que hagi assistit a més torneigs.
			<li>2. El jugador que hagi fet més tops.
			<li>3. El jugador que hagi guanyat més torneigs.
		</ul>
</ul>
</div>

<?php include 'footer.php' ?>
