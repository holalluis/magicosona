var PW = {}

//funció a jugador.php
PW.getPoints=function(dci,container) {
	var sol=new XMLHttpRequest();
	sol.open('GET','pwPoints.php?dci='+dci,true);
	sol.timeout=10000;
	sol.onreadystatechange = function () {
		if(sol.readyState === XMLHttpRequest.DONE && sol.status === 200) {
				//Afegeix la resposta al container element
				var resposta=sol.responseText;
				var json=JSON.parse(resposta);
				container.innerHTML=(function(){

					if(json.se=="")json.se=0;

					var ul="<b>Punts planeswalker:</b><ul style=list-style:circle>";
					ul+="<li>Level: "+json.lvl;
					ul+="<li>Lifetime points: "+json.lt;
					ul+="<li>Season points: "+json.se;
					ul+="<li><a target=_blank href='https://www.wizards.com/Magic/PlaneswalkerPoints/"+dci+"'>Més info (wizards)</a>";
					ul+="</ul>"
					return ul;
				})();
		}
	};
	sol.ontimeout=function() {
		container.innerHTML="Punts planeswalker no trobats";
	};
	sol.send();
}

//funció a jugadors.php
//dci: number. target: html element
PW.getPoints2=function(dci,target) {
	var sol=new XMLHttpRequest();
	sol.open('GET','pwPoints.php?dci='+dci,true);
	sol.onreadystatechange=function() {
		if(sol.readyState === XMLHttpRequest.DONE && sol.status === 200) {
				var resposta=sol.responseText;
				try{
					var json=JSON.parse(resposta);
					target.innerHTML=(function(){
						var lt=json.lt;
						var se=json.se;
						var lvl=json.lvl;
						if(lt=="")lt=0;
						if(se=="")se=0;
						if(lvl=="")lvl=0;
						return "<b>Lvl</b>: "+lvl+", <b>Lifetime</b>: "+lt+", <b>Season</b>: "+se;
					})()
				}catch(e){
					target.innerHTML="<span style=color:#ccc;font-size:11px>~DCI no vàlid</span>"
				}
		}
		//loop detected
		if(sol.readyState === XMLHttpRequest.DONE && sol.status === 508) {
			target.innerHTML="<span style=color:orange;font-size:11px>Esperant resposta del servidor Wizards...</span>"
			setTimeout(function(){PW.getPoints2(dci,target)},10000+Math.random()*5000) //espera entre 10 i 15 segons
		}
	};
	sol.send()
}
