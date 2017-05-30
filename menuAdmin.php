<?php
	if(isset($_COOKIE['admin'])) { ?>
		<style>
			#menuAdmin{
				display:flex;
				flex-wrap:wrap;
				justify-content:center;
				padding:5px;
				font-size:14px;
				background:rgb(0,150,136);
			}
			#menuAdmin a {
				text-decoration:none;
			}
			#menuAdmin .item {
				display:block;
				text-decoration:none;
				border:1px solid #3b5998;
				padding:0.5em;
				margin-right:-1px;
				margin-top:-1px;
				background:gold;
			}
			#menuAdmin .item:hover {
				background:#3b5998;
				transition:all 0.5s;
				color:gold;
			}
			#menuAdmin .item:hover a {
				color:gold;
			}
		</style>
		<div id=menuAdmin>
			<div style=padding:0.5em;color:white>Menú Admin</div>
			<div class=flex>
				<div class=flex>
					<div class=item><a href='nouJugador.php'>Nou jugador</a></div>
					<div class=item><a href='nouEsdeveniment.php'>Nou Esdeveniment</a></div>
					<div class=item><a href=baralles.php>Baralles</a></div>
					<div class=item><a href=assistents.php>Pròxim torneig</a></div>
				</div>
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
			</div>
			<div class=item>
				<a href=controller/logout_admin.php>Surt mode admin</a>
			</div>
		</div>
		<script>
			//posa un nou jugador a la llista d'assistents al proxim torneig
			function nouAssistent() {
				var id_jugador=document.getElementById('id_assistent').value;
				window.location='nouAssistent.php?id_jugador='+id_jugador;
			}
		</script>
		<?php
	}
?>
