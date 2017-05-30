<?php
	// PÀGINA PRINCIPAL
	include 'mysql.php';
	function comptaPot() {
		$pot=0; //euros
		$res=mysql_query("SELECT * FROM esdeveniments");
		while($row=mysql_fetch_assoc($res)) {
			$id_esdeveniment=$row['id'];
			$sql="SELECT COUNT(id) FROM resultats WHERE id_esdeveniment=$id_esdeveniment";
			$participants=current(mysql_fetch_assoc(mysql_query($sql)));
			$pot+=2*$participants; //2 euros per participant
		}
		return $pot;
	}
?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Magic Osona - Pàgina Principal</title>
	<script>
		//posa un nou jugador a la llista d'assistents al proxim torneig
		function nouAssistent() {
			var id_jugador = document.getElementById('id_assistent').value;
			window.location='nouAssistent.php?id_jugador='+id_jugador
		}
	</script>
	<style>
		/*primers 16 files color gold*/
		#taula tr:nth-child(-n+17) td:first-child {background:gold}
	</style>
</head><body><center>
<!--menus--><?php include'menu.php'?>
<!--LOGO--><h2>Magic Osona — Lliga Modern</h2>
<!--NEXT torneig--><?php include 'proximEsdeveniment.php' ?>

<!--pot-->
<div style=margin:0.5em> 
	Pot acumulat (<?php echo current(mysql_fetch_assoc(mysql_query("SELECT COUNT(1) FROM esdeveniments")))?> torneigs): <b><?php echo comptaPot() ?> €</b> 
</div>

<!--classificació general-->
<table cellpadding=5 id=taula>
	<style>
		#taula {
			max-width:90%;
			text-align:left;
		}
	</style>
	<tr><th title="Posició">#<th><b>Classificació</b>
	<?php
		// Llista d'esdeveniments
		$sql="SELECT * FROM esdeveniments ORDER BY data ASC";
		$res=mysql_query($sql);

		if(mysql_num_rows($res)==0){
			echo "<tr><td>~<td>0 torneigs celebrats aquesta temporada";
		}
		else{
			$torneigs=[];
			while($row=mysql_fetch_assoc($res)) {
				$id=$row['id'];
				$nom=$row['nom'];
				$dat=date("d/m/Y",strtotime($row['data']));
				echo "<th title='$dat'><a href=esdeveniment.php?id=$id>$nom</a>";
				$torneigs[]=$id;
			}
			?>
			<th>Total
			<?php
			//un sol query sense javascript
			/**
				-----------------------------------------
				nom					   t1   t2   t3     total
				-----------------------------------------
				lluis bosch    10   10   10     30
				lluis bosch    10   10   10     30
				-----------------------------------------
				$sql="
					SELECT 
						r.id,
						r.date,
						GROUP_CONCAT(IF(r.device_id = 1,r.VALUE,NULL)) AS device_id_1,
						GROUP_CONCAT(IF(r.device_id = 2,r.VALUE,NULL)) AS device_id_2
					FROM readings r
						GROUP BY r.DATE
						ORDER BY r.DATE ASC;
				";
			**/
			$group_concats=[];
			$coma = count($torneigs)>0 ? "," : "";
			foreach($torneigs as $key=>$id) {
				$group_concats[]="GROUP_CONCAT(IF(r.id_esdeveniment = $id,r.punts,NULL)) AS T".($key+1);
			}
			$sql="
				SELECT 
					j.nom,
					j.id,
					".implode(",",$group_concats)."$coma"."
					SUM(r.punts) AS total
				FROM 
					resultats r,jugadors j
				WHERE
					r.id_jugador=j.id
				GROUP BY 
					r.id_jugador
				ORDER BY 
					total DESC
			";
			$res=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_assoc($res)) {
				//número i nom
				echo "<tr><td>$i<td><a href=jugador.php?id=".$row['id'].">".$row['nom']."</a>";
				//punts per torneig
				foreach($torneigs as $key=>$id)
				{
					echo "<td>".$row["T".($key+1)];
				}
				echo "<td><b>".$row['total']."</b>";
				$i++;
			}
		}
		?>
</table>

<?php include 'footer.php' ?>
