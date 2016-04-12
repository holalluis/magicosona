<?php
	// MENU ADMINISTRADOR
	if(isset($_COOKIE['admin']))
	{
		echo "<div style='padding:0.5em;background-color:#ccc;'>";
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

		//nou assistent
		echo "Nou Assistent: ";
		echo "<select id=id_assistent>";
		$sql="	SELECT id,nom 
			FROM jugadors 
			WHERE NOT EXISTS 
				(SELECT 1 FROM assistentsProximTorneig WHERE assistentsProximTorneig.id_jugador = jugadors.id) 
			ORDER BY jugadors.nom";
		$res=mysql_query($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$id=$row['id'];
			$nom=$row['nom'];
			echo "<option value=$id>$nom</option>";
		}
		echo "</select> ";
		echo "<button onclick=nouAssistent()>Guarda</button>";

		echo "</div>";
	}
?>
