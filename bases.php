<!doctype html><html><head>
	<?php include'mysql.php'?>
	<?php include'imports.php'?>
	<title>Bases</title>
	<style>
		ul{list-style-type:none;padding-left:1em}
		hr{margin-top:0.5em}
		div > ul > li{border-bottom:1px solid #ccc;margin-bottom:0.5em;padding-bottom:0.5em}
	</style>
</head><body><center>
<?php include'menu.php'?>
<h2>Bases / Normes de la lliga</h2>

<div style=text-align:left;margin-top:0.5em>
<ul>
	<li><b>Informació general</b>
		<ul>
			<li>Benvingut a la Lliga Osonenca de Modern!
			<li>Si no has jugat mai a Magic, llegeix <a target=_blank href="http://media.wizards.com/2014/docs/SP_M15_QckStrtBklt_LR_Crop.pdf">aquesta guia d'inici</a>.
			<li>El format que juguem és <a target=_blank href="http://magic.wizards.com/es/gameinfo/gameplay/formats/modern">Modern (mira les normes)</a>.
			<li>Celebrem els torneigs al Club Billar Vic, <a target=_blank href="https://www.google.es/maps/place/Carrer+de+l'Arquebisbe+Alemany,+24,+08500+Vic,+Barcelona/@41.9319626,2.2490315,17z/data=!3m1!4b1!4m2!3m1!1s0x12a5271b7b0f0561:0x9d4451d075aba9b1">C/Arquebisbe Alemany 24-26, Vic</a>.
			<li>Cada tercer diumenge de mes (normalment).
			<li>Inscripcions: per la web, o el mateix dia, de 9:00h a 10:00h.
			<li>Inici del torneig: 10:00h. 
			<li>Preu inscripció: 12€ (10€ per premis i 2€ acumulats per la final). <b>Els preus poden variar si fem premis especials</b>.
			<li>Al final de la lliga es farà una final on només podran jugar els 16 primers classificats.
			<li>A cada torneig s'ha de portar la llista, o enviar-la per la pàgina de perfil (queda oculta a la resta).
		</ul>
	<li><b>Rondes</b>
		<ul>
			<li>Cada torneig consistirà de dues parts: <b>suís</b> i <b>top</b>.
			<li>Suís: 
			Seguirem la recomanació oficial de la DCI, amb el següent nombre de rondes:
			<table>
				<tr><th>Jugadors<th>Nombre de rondes
				<tr><td>17-32<td>5 rondes de suís
				<tr><td>33-64<td>6 rondes de suís
				<tr><td>64-128<td>7 rondes de suís
			</table>
			<li>Les rondes tindran una durada de 45-50 minuts cadascuna. 
			<li>Quan s’acabi el temps de ronda, es deixarà als jugadors 5 torns més per acabar la partida. 
		</ul>
	<li><b>Puntuació</b>
		<ul>
			<li>Durant les rondes del suís, es jugarà al millor de 3 partides. El guanyador rebrà 3 punts.
			Empat: 1 punt, derrota: 0 punts.
			<li>La puntuació que es rebrà per la lliga serà segons el punts acumulats durant el suís.
			<li>Puntuació extra:
				<ul>
					<li>Al final del suís, el primer classificat rebrà un punt extra, i a més a més, depenent de la posició:<br>
						<table>
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
						<table>
							<tr><th>#<th colspan=2>En cas de TOP 4
							<tr><td>1r:<td>  1 + 1 + 2  <td>= 4 punts
							<tr><td>2n:<td>  1 + 1			<td>= 2 punts
							<tr><td>3r:<td>  1					<td>= 1 punt
							<tr><td>4t:<td>  1					<td>= 1 punt
						</table>
						<li>Es farà TOP 4 en cas que hi hagi menys de 17 jugadors al torneig, sinó, es farà TOP 8.
				</ul>
		</ul>
	<li><b>Top 8</b>
		<ul>
			<li>Després del suís, els 8 jugadors amb més punts entraran dins del top 8, que es farà per eliminatòries, on no hi haurà límit de temps.
			<li>Els encreuaments es faran de la següent manera:
				<ul>
					<li>1r vs 8è
					<li>2n vs 7è
					<li>3r vs 6è
					<li>4rt vs 5è
					<li>El jugador més ben classificat decidirà qui comença.
				</ul>
			<li>Les semifinals i finals també s'encreuaran d'aquesta manera.
			<li>Durant el top, el jugador més ben classificat decideix si comença la partida.
		</ul>
	<li><b>El torneig final</b>
		<ul>
			<li>Un cop finalitzats tots els esdeveniments de la lliga, els 16 jugadors amb més puntuació estaran classificats per la final.
			<li>L'estructura de la final es comunicarà uns dies abans. S’aplicaran les mateixes normes explicades anteriorment.
		</ul>
	<li><b>Desempats</b>
		<ul>
			<li>En cas d’acabar la lliga i que 2 o més jugadors/es estiguin empatats a punts, els criteris de desempats per ordre d’importància són:
			<li>1. El jugador que hagi assistit a més torneigs.
			<li>2. El jugador que hagi fet més tops.
			<li>3. El jugador que hagi guanyat més torneigs.
		</ul>
	<li><b>Salut i Magic!</b>
</ul>
</div>
<?php include 'footer.php' ?>
