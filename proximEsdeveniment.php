<?php include 'dataProximTorneig.php'?>

<!-- PROXIM ESDEVENIMENT -->
<div style="padding:0.5em;background-color:gold;box-shadow: 0 5px 5px -5px rgba(0,0,0,0.3);">
	<?php 
		//compta el numero de jugadors apuntats
		$assistents=mysql_num_rows(mysql_query("SELECT * FROM assistentsProximTorneig"));
		echo "
			<b>Pròxim torneig: </b> $dataProximTorneig
			—
			<a href='assistents.php' title='Clica aquí per veure els jugadors inscrits'>$assistents jugadors inscrits</a>";
	?>
</div> 

