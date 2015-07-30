<script>

function compta()
//donada una data, genera un compte enrere pel proxim torneig
{
	var data=new Date(<?php echo "'$dataProximTorneig'" ?>);
	var avui=new Date();
	var falta=data-avui 	//en milisegons
	if(falta<0) { falta=0; return }

	//ho convertim a dies, hores, minuts i segons
	var dd = Math.floor(falta/86400000) 	
	var hh = Math.floor(falta/86400000*24)		-dd*24;
	var mm = Math.floor(falta/86400000*24*60)	-hh*60-dd*24*60;
	var ss = Math.floor(falta/86400000*24*60*60)	-mm*60-hh*60*60-dd*24*60*60;

	var str = "Falten: "+dd+"d, "+hh+"h, "+mm+"m, "+ss+"s"

	document.getElementById('comptador_dies').innerHTML=str
}

</script>
