<?php
	// MENU ADMINISTRADOR
	if(isset($_COOKIE['admin']))
	{
		?>
		<style>
			#menuAdmin{
				display:flex;
				flex-wrap:wrap;
				justify-content:center;
				margin:5px 0;
			}
			#menuAdmin .item {
				display:block;
				text-decoration:none;
				border:1px solid #ccc;
				border-bottom:1px solid #ddd;
				padding:0.5em;
				margin-right:-1px;
				margin-top:-1px;
			}
			#menuAdmin a:hover {
				background-color:#fefefe;
				border-bottom-color:#395693;
			}
		</style>
		<div id=menuAdmin>
			<div class=item> Menú Admin </div>
			<div class=item><a href='nouJugador.php'>Nou jugador</a></div>
			<div class=item><a href='nouEsdeveniment.php'>Nou Esdeveniment</a></div>
			<div class=item><a href=baralles.php>Baralles</a></div>
			<div class=item><a href=assistents.php>Pròxim torneig</a></div>
			<div class=item>
				Nou Assistent:
				<select id=id_assistent>
					<?php
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
					?>
				</select>
				<button onclick=nouAssistent()>Guarda</button>
			</div>
			<div class=item>
				<a href=controller/logout_admin.php>Logout admin</a>
			</div>
		</div>
		<?php
	}
?>
