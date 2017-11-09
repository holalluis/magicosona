<?php
	include'mysql.php';
	function comptaPot() {
		global $mysql;
		$pot=0; //euros
		$res=$mysql->query("SELECT * FROM esdeveniments");
		while($row=mysqli_fetch_assoc($res)) {
			$id_esdeveniment=$row['id'];
			$sql="SELECT COUNT(id) FROM resultats WHERE id_esdeveniment=$id_esdeveniment";
			$participants=current(mysqli_fetch_assoc($mysql->query($sql)));
			$pot+=2*$participants; //2 euros per participant
		}
		return $pot;
	}
?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Pàgina Principal</title>
	<style>
		#navbar [index]{
			background:#fefefe;
			border-bottom-color:#395693;
		} 
		td.top {
			font-size:smaller;
			text-align:right;
		}
	</style>
</head><body><center>
<!--menus--><?php include'menu.php'?>
<!--LOGO--><h2>Magic Osona — Lliga Modern</h2>
<!--NEXT torneig--><?php include 'proximEsdeveniment.php' ?>
<!--pot-->
<div style=margin:0.5em;font-size:smaller>
	Pot acumulat (<?php echo current(mysqli_fetch_assoc($mysql->query("SELECT COUNT(1) FROM esdeveniments")))?> torneigs): 
	<b><?php echo comptaPot() ?> €</b> 
</div>

<!--fig planeswalker points-->
<p style=font-size:smaller>
	<a href=puntsPW/punts.php>
		Gràfic 'Punts Planeswalker jugadors Osona'
	</a>
</p>

<!--classificació general-->
<table id=taula>
	<style>
		#taula {
			max-width:90%;
			text-align:left;
		}
		/*primers 16 files color gold*/
		#taula tr:nth-child(-n+17) td:first-child {background:gold}
	</style>
	<tr><th title="Posició" colspan=2 style=text-align:center>Classificació general
	<?php
		// Llista d'esdeveniments
		$sql="SELECT * FROM esdeveniments ORDER BY data ASC";
		$res=$mysql->query($sql);

		if(mysqli_num_rows($res)==0){
			echo "<th><b>Total</b>";
			//mostra tots els jugadors i "0 punts"
			$sql="SELECT * FROM jugadors ORDER BY nom";
			$res=$mysql->query($sql);
			while($row=mysqli_fetch_assoc($res)) {
				$id=$row['id'];
				$nom=$row['nom'];
				echo "<tr><td>1<td><a href=jugador.php?id=$id>$nom</a><td>0 punts";
			}
		}
		else{
			$torneigs=[];
			while($row=mysqli_fetch_assoc($res)) {
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
			$res=$mysql->query($sql);
			$i=1;
			while($row=mysqli_fetch_assoc($res)) {
				//número i nom
				echo "<tr><td class=top>$i<td><a href=jugador.php?id=".$row['id'].">".$row['nom']."</a>";
				//punts per torneig
				foreach($torneigs as $key=>$id) {
					echo "<td><small>".$row["T".($key+1)]."</small>";
				}
				echo "<td><b>".$row['total']."</b>";
				$i++;
			}
		}
	?>
</table>

<?php include 'footer.php' ?>
