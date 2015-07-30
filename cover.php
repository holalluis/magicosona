<!--cover.php-->
<script>
	function mostraCover(carta,e)
	{
		/*
		 * modifica src del cover, desoculta'l i mou-lo
		 */
		var cover = document.getElementById('cover')
		cover.style.left=(e.pageX+10)+"px"
		cover.style.top=Math.max(0,e.pageY-200)+"px"
		var sol = new XMLHttpRequest()
		var url="http://api.mtgapi.com/v1/card/name/"+carta
		sol.open('GET',url,false)
		sol.send()
		//la api torna un array de cartes
		var resposta = JSON.parse(sol.responseText)
		console.log(resposta)
		var id=null
		var i=0
		while(i<resposta.length)
		{ 
			if(resposta[i].name.toUpperCase()==carta.toUpperCase() && resposta[i].id!==null)
			{
				id=resposta[i].id
				break;
			}
			i++ 
		}
		//busca imatge per id
		var src="http://gatherer.wizards.com/Handlers/Image.ashx?type=card&multiverseid="+id
		cover.src=src
		//ensenya
		cover.style.display=''
	}
	function amagaCover()
	{
		document.getElementById('cover').style.display='none'
	}
</script>

<!--imatge mobil-->
<img 
    id=cover 
    src='img/cardThumbnail.png'
    style="	position:absolute;
		left:0px;
		border-radius:0.2em;
		top:0px;
		display:none;"
/>
<!--/cover.php-->
