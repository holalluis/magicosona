var Jugadors=[
	/*{nom,lvl,lifetime,season}*/
	{nom:"Adrià Simon",	lvl: 34, lifetime: 2447, season: 24},
	{nom:"Adrià Solé",	lvl: 37, lifetime: 4831, season: 88},
	{nom:"Albert Casulleras",	lvl: 36, lifetime: 3389, season: 11},
	{nom:"Albert Gómez",	lvl: 33, lifetime: 1994, season: 92},
	{nom:"Alberto Arias Soria",	lvl: 22, lifetime: 345, season: 15},
	{nom:"Aleix Arboix",	lvl: 32, lifetime: 1407, season: 9},
	{nom:"Alejandro Barragan",	lvl: 35, lifetime: 2706, season: 31},
	{nom:"Arnau Arís",	lvl: 37, lifetime: 5474, season: 126},
	{nom:"Bernat Martí",	lvl: 38, lifetime: 6693, season: 105},
	{nom:"Brian Cruz",	lvl: 6, lifetime: 27, season: 0},
	{nom:"Carles Cabello",	lvl: 24, lifetime: 404, season: 0},
	{nom:"Danan Morera",	lvl: 33, lifetime: 1982, season: 0},
	{nom:"Dani Leiva",	lvl: 2, lifetime: 9, season: 0},
	{nom:"Daniel Chueca",	lvl: 34, lifetime: 2296, season: 373},
	{nom:"Daniel Garcia",	lvl: 30, lifetime: 902, season: 27},
	{nom:"Daniel Luque",	lvl: 27, lifetime: 660, season: 4},
	{nom:"David Altimir",	lvl: 31, lifetime: 1222, season: 0},
	{nom:"David Badia",	lvl: 22, lifetime: 316, season: 21},
	{nom:"David Marin",	lvl: 3, lifetime: 11, season: 0},
	{nom:"David Padrosa",	lvl: 27, lifetime: 612, season: 17},
	{nom:"David Pujol",	lvl: 22, lifetime: 346, season: 7},
	{nom:"David Ros",	lvl: 33, lifetime: 2006, season: 99},
	{nom:"David Ruano",	lvl: 32, lifetime: 1571, season: 18},
	{nom:"Edgar Saló",	lvl: 16, lifetime: 125, season: 2},
	{nom:"Enric Montoya",	lvl: 29, lifetime: 827, season: 18},
	{nom:"Enric Reig",	lvl: 21, lifetime: 271, season: 0},
	{nom:"Enric Subirà",	lvl: 11, lifetime: 57, season: 9},
	{nom:"Enric Torné",	lvl: 15, lifetime: 99, season: 7},
	{nom:"Ernest Puntí",	lvl: 24, lifetime: 436, season: 0},
	{nom:"Fran Valhondo",	lvl: 33, lifetime: 2098, season: 7},
	{nom:"Francesc Xavier Badia",	lvl: 19, lifetime: 218, season: 0},
	{nom:"Gabriel Comaposada",	lvl: 39, lifetime: 7503, season: 19},
	{nom:"Gerard Ballell",	lvl: 32, lifetime: 1593, season: 20},
	{nom:"Guillem Capdevila",	lvl: 7, lifetime: 34, season: 0},
	{nom:"Hendrys Tobar",	lvl: 24, lifetime: 429, season: 0},
	{nom:"Ignasi Ríos",	lvl: 14, lifetime: 88, season: 0},
	{nom:"Ivan de Castro",	lvl: 41, lifetime: 10127, season: 12},
	{nom:"Jaume Palacios",	lvl: 30, lifetime: 973, season: 9},
	{nom:"Javier Zurano",	lvl: 31, lifetime: 1171, season: 30},
	{nom:"Joan Tarrida",	lvl: 27, lifetime: 670, season: 8},
	{nom:"Jordi Alapont",	lvl: 26, lifetime: 522, season: 0},
	{nom:"Jordi Bardulet",	lvl: 34, lifetime: 2442, season: 0},
	{nom:"Jordi Camacho",	lvl: 32, lifetime: 1681, season: 17},
	{nom:"Jordi Galobardes",	lvl: 27, lifetime: 681, season: 7},
	{nom:"Jordi Gutierrez ",	lvl: 28, lifetime: 778, season: 35},
	{nom:"Jordi Ribas",	lvl: 27, lifetime: 641, season: 0},
	{nom:"José Antonio Martín",	lvl: 37, lifetime: 5311, season: 80},
	{nom:"Jose Luis Huarte",	lvl: 1, lifetime: 0, season: 0},
	{nom:"Jose Núñez",	lvl: 31, lifetime: 1113, season: 46},
	{nom:"Leticia Sevilla",	lvl: 30, lifetime: 992, season: 0},
	{nom:"Lluís Bosch",	lvl: 31, lifetime: 1301, season: 0},
	{nom:"Manel Torruella",	lvl: 26, lifetime: 590, season: 30},
	{nom:"Marc Albureca",	lvl: 18, lifetime: 186, season: 0},
	{nom:"Marc Gimeno",	lvl: 15, lifetime: 98, season: 0},
	{nom:"Marc López",	lvl: 32, lifetime: 1488, season: 0},
	{nom:"Marc Llopart",	lvl: 37, lifetime: 5727, season: 4},
	{nom:"Marc Márquez",	lvl: 4, lifetime: 17, season: 6},
	{nom:"Marc Taña",	lvl: 27, lifetime: 689, season: 8},
	{nom:"Maria Luque",	lvl: 26, lifetime: 547, season: 59},
	{nom:"Nils Gutiérrez",	lvl: 36, lifetime: 4305, season: 0},
	{nom:"Oliver Medina",	lvl: 37, lifetime: 5609, season: 48},
	{nom:"Omar Nieto",	lvl: 32, lifetime: 1524, season: 0},
	{nom:"Oriol Hita",	lvl: 18, lifetime: 162, season: 0},
	{nom:"Pau Canadell",	lvl: 36, lifetime: 3395, season: 0},
	{nom:"Pau Carbonell",	lvl: 1, lifetime: 0, season: 0},
	{nom:"Pedro Posada",	lvl: 31, lifetime: 1315, season: 0},
	{nom:"Pol Vivancos",	lvl: 28, lifetime: 768, season: 36},
	{nom:"Robert Masdevall",	lvl: 29, lifetime: 831, season: 0},
	{nom:"Sergio Aragón",	lvl: 36, lifetime: 3796, season: 78},
	{nom:"Toni Romero",	lvl: 26, lifetime: 558, season: 0},
	{nom:"Xavier Droch",	lvl: 31, lifetime: 1060, season: 4},
	{nom:"Xavier Puig",	lvl: 27, lifetime: 633, season: 0},
	{nom:"Xevi Osorio",	lvl: 33, lifetime: 2093, season: 44},
];
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(sort);

function dibuixa() {
	div_id='chart';
	var DATA=[ 
		['Jugador','Lifetime points','Season points'],
	];
	Jugadors.forEach(j=>{DATA.push([j.nom,j.lifetime,j.season]);});
	var data=google.visualization.arrayToDataTable(DATA);

	var options = {
		legend:{position:'top'},
		fontSize:"11",
		chartArea:{
			top:50,
		},
		width:"100%",
		height:3000,
		bars:'horizontal',
		bar:{
			groupWidth:"75%",
		},
		isStacked:false,
	};
	var chart=new google.visualization.BarChart(document.getElementById(div_id));
	chart.draw(data,options);
}

//ordena i dibuixa
function sort(attr){
	if(!attr){attr='lifetime';}
	Jugadors.sort((a,b)=>{
		if (a[attr] < b[attr])
			return 1;
		if (a[attr] > b[attr])
			return -1;
		return 0;
	});
	dibuixa();
}

