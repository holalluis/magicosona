<div style="margin:0;background-color:#395693;color:white;padding:0.5em">
<?php
	if(isset($_COOKIE['admin']))
	{ ?>
		Sessió iniciada com a ADMINISTRADOR | <a href="controller/logout.php" style=color:white>Finalitza sessió</a>
	<?php }
	else if(isset($_COOKIE['jugador']))
	{
		$sql="SELECT nom FROM jugadors WHERE id=".$_COOKIE['jugador'];
		$ress=mysql_query($sql) or die('error');
		$roww=mysql_fetch_assoc($ress);
		$nom=$roww['nom'];
		echo "Sessió iniciada com a 
			<a style=color:white href=jugador.php?id=".$_COOKIE['jugador'].">$nom</a>";
		echo " <button onclick=window.location='controller/logout.php'>Finalitza sessió</button>";
	}
	else
	{
		echo "<i>Sessió no iniciada </i>";
		echo " <select onchange=window.location='jugador.php?id='+this.value>";
		echo "<option>--SELECCIONA--";
		$res=mysql_query("SELECT * FROM jugadors ORDER BY nom ASC");
		while($roww=mysql_fetch_assoc($res)) echo "<option value=".$roww['id'].">".$roww['nom'];
		echo "</select>";
	}
?>
</div>
