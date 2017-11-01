<?php include 'mysql.php'; ?>
<!doctype html> <html> <head>
	<?php include 'imports.php' ?>
	<title>Lliga Osonenca de Modern - Jugadors</title>
	<script src=pwPoints.js></script>
	<style>
	#navbar [jugadors]{
		background:#fefefe;
		border-bottom-color:#395693;
	} 
	</style>
</head>
<body><center>
<?php include 'menu.php' ?>

<!--LOGO-->
<h2> Tots els jugadors A-Z (<?php echo mysqli_num_rows($mysql->query("SELECT 1 FROM jugadors")) ?>)</a> </h2>

<!--jugadors-->
<table style=margin-top:0.5em> 
	<tr><th>Nom<th>DCI<th>Planeswalker points
	<?php
		$sql="SELECT * FROM jugadors ORDER BY nom";
		$res=$mysql->query($sql);
		$pwPoints=Array();

		while($row=mysqli_fetch_assoc($res))
		{
			$id=$row['id'];
			$nom=$row['nom'];
			$dci=$row['dci'] ? $row['dci'] : "";
			echo "<tr jugador=$id><td><a href='jugador.php?id=$id'>$nom<td>$dci";
			if($dci)
			{
				$pwPoints[]=[$dci,$id];
				echo "<td>
				<div class=pwPoints>
					<button onclick=veurePWpoints($dci,$id,this)>Veure PW points</button>
				</div>";
			}
			else echo "<td style=font-size:11px;color:#ccc>~No hi ha DCI";
		}
	?>
</table>

<script>
	function veurePWpoints(dci,id,btn){
		btn.innerHTML="Carregant PW points...";
		btn.classList.add('carregant');
		PW.getPoints2(dci,document.querySelector('tr[jugador="'+id+'"] div.pwPoints'))
	}
</script>

<style>
	button.carregant {
		color:orange;
		pointer-events:none;
		outline:none;
	}
</style>

<?php include 'footer.php' ?>
