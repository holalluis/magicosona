<?php include 'mysql.php'; ?>
<!doctype html><html><head>
	<?php include 'imports.php' ?>
	<title>Torneigs</title>
	<style>
		.jugadors_data{font-size:12px}
		#torneigs td {
			padding:0.9em 0.4em
		}
		#navbar [torneigs]{
			background:#fefefe;
			border-bottom-color:#395693;
		} 
	</style>
</head> <body><center>
<?php include 'menu.php' ?>
<h2>Torneigs celebrats aquesta temporada</h2>

<!--NEXT torneig--><?php include 'proximEsdeveniment.php' ?>

<div class=flex style=margin-top:0.5em>

<!--veure meta-->
<div style="max-width:28%;">
	<button style="margin-right:5px;padding:1.5em 0.5em" onclick="window.location='metagame.php'">Veure metagame</button>
</div>

<!--Torneigs-->
<div style="max-width:70%;">
	<table id=torneigs>
		<?php
			$sql="SELECT * FROM esdeveniments ORDER BY data DESC";
			$res=$mysql->query($sql);
			if(mysqli_num_rows($res)==0) {
				echo "<tr><td>~0 torneigs celebrats aquesta temporada";
			}
			while($row=mysqli_fetch_assoc($res)) {
				$id=$row['id'];
				$nom=$row['nom'];
				$data=$row['data'];
				$timeAgo=timeAgo($data);
				$data_for=date("d/m/Y",strtotime($data));
				$jugadors=current(mysqli_fetch_assoc($mysql->query("SELECT COUNT(*) FROM resultats WHERE id_esdeveniment=$id")));
				echo "
					<tr>
						<td>
							<a href=esdeveniment.php?id=$id>
                $nom
                &mdash;
                <span class=jugadors_data>
                  $jugadors jugadors · $data_for · $timeAgo
                </span>
              </a>
				";
			}
		?>
	</table>
</div>

</div>

<?php include 'footer.php' ?>
