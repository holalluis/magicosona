<?php
	// MENU ADMINISTRADOR
	if(isset($_COOKIE['admin']))
	{
		echo "<div style='padding:0.5em;background-color:#abc;'>";
		echo "Menú Admin: ";

		//nou jugador
		echo "<a href='nouJugador.php'>Nou jugador</a>";
		echo " | ";

		//nou esdeveniment
		echo "<a href='nouEsdeveniment.php'>Nou Esdeveniment</a>";
		echo " | ";

		//baralles
		echo " <a href=baralles.php>Baralles</a>";
		echo " | ";

		//proxim torneig
		echo "<a href=assistents.php>Pròxim torneig</a>";
		echo " | ";

		//nou assistent
		echo "Nou Assistent: ";
		echo "<select id=id_assistent>";
		$sql="	SELECT id,nom 
			FROM jugadors 
			WHERE NOT EXISTS 
				(SELECT 1 FROM assistentsProximTorneig WHERE assistentsProximTorneig.id_jugador = jugadors.id) 
			ORDER BY jugadors.nom";
		$res=mysql_query($sql);
		while($rowAdmin=mysql_fetch_assoc($res))
		{
			$idAdmin=$rowAdmin['id'];
			$nomAdmin=$rowAdmin['nom'];
			echo "<option value=$idAdmin>$nomAdmin</option>";
		}
		echo "</select> ";
		echo "<button onclick=nouAssistent()>Guarda</button>";

		echo "</div>";
	}
?>
