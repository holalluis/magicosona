<?php include 'dataProximTorneig.php'?>

<!-- PROXIM ESDEVENIMENT -->
<div style="padding:0.7em;background-color:gold;box-shadow: 0 5px 5px -5px rgba(0,0,0,0.3);">
	<style>
		@keyframes blink { from {background-color:none;} to {background-color:white;} }	
		#faltenBlink {
			margin-left:0.3em;
			margin-right:0.3em;
			font-weight:bold;
			padding:0.3em;
			border-radius:0.5em;
			animation: blink 4s ease 0.5s infinite alternate;
			}
	</style>
	<?php 
		//compta el numero de jugadors apuntats
		$assistents=mysql_num_rows(mysql_query("SELECT * FROM assistentsProximTorneig"));
		echo "
			<a href=assistents.php>Pròxim torneig: </a> $dataProximTorneig
			<span id=faltenBlink>Falten $falten dies</span>
			<a href='assistents.php' title='Clica aquí per veure els jugadors inscrits'>$assistents jugadors inscrits</a>";
	?>
</div> 

