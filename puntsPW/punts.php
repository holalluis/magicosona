<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Lliga osonenca de Modern. Torneigs mensuals de Magic the Gathering a Vic, Osona">
	<link rel="icon" href="../img/favicon.ico" type="image/x-icon">
	<style>
		body{
			margin:0;
      font-family:'Helvetica Neue','Liberation Sans',sans-serif;
		}
		#btns_sort button {
			padding:1em 0.3em;
			border:1px solid #ccc;
			border-radius:0.5em;
			margin:1px;
			display:block;
			color:white;
		}
		#btns_sort {
			padding:1em 0;
		}
		h3{
			background:#eee;
			margin:0;
			padding:1em;
		}
		#root{
			margin:5px;
		}
	</style>
</head><body><center>
<h3><a href="../">&larr; Enrere</a></h3>

<div id=root>
<h2>Planeswalker points (consultat el 04/09/2018)</h2>
<div id=btns_sort>
	<p>
		<b>Ordena per: </b><br>
		<label><input type=radio name=sorting onclick=sort('Lifetime') checked> Lifetime points</label>
    <br>
		<label><input type=radio name=sorting onclick=sort('Season')>   Season points</label>
	</p>
</div>
<div id="chart" style=vertical-align:top><div style=background:yellow>Carregant...</div></div>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="punts.js"></script>
