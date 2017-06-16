<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Lliga osonenca de Modern. Torneigs mensuals de Magic the Gathering a Vic, Osona">
	<link rel="icon" href="../img/favicon.ico" type="image/x-icon">
	<style>
		#btns_sort button {
			padding:1em 0.3em;
			border:1px solid #ccc;
			border-radius:0.5em;
			margin:1px;
			display:block;
		}
		#btns_sort {
			padding:1em 0;
			display:flex;
			flex-wrap:wrap;
		}
	</style>
</head><body>
<h3><a href="../jugadors.php">&larr; Enrere</a></h3>

<h2>Planeswalker points (16/06/2017)</h2>

<div>
	Punts dels jugadors de la lliga ordenats per punts totals (lifetime points) o de temporada (season points).
</div>

<div id=btns_sort>
	<b>Ordena per:</b>
	<button onclick=sort('lifetime')>Lifetime points</button>
	<button onclick=sort('season')>Season points</button>
</div>

<div id="chart" style=vertical-align:top></div>

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="punts.js"></script>
