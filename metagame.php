<?php include 'mysql.php' ?>
<!doctype html><html><head>
  <?php include 'imports.php' ?>
  <title>Metagame lliga</title>
  <style> #metagame th,#metagame td {border-left:none;border-right:none} </style>
</head><body onload="ordena('metagame',1)"><center>
<?php include 'menu.php' ?>

<h2><a href=torneigs.php>Torneigs</a> &rsaquo; Metagame</h2>

<table id=metagame style=margin-top:0.5em>
<tr><th>Baralla<th>Aparicions a la lliga
  <?php
    $sql="
      SELECT 
        DISTINCT baralla, COUNT(baralla) AS aparicions, nom 
      FROM 
        resultats,baralles 
      WHERE 
        baralla>0 AND resultats.baralla=baralles.id 
      GROUP BY 
        baralla 
      ORDER BY 
        aparicions DESC
    ";
    $res=$mysql->query($sql);
    while($row=mysqli_fetch_assoc($res)) {
      $id  = $row['baralla'];
      $aps = $row['aparicions'];
      $nom = $row['nom'];
      echo "<tr>
        <td><a href=baralla.php?id=$id>$nom</a>
        <td>$aps";
    }
    if(mysqli_num_rows($res)==0) {
      echo "<tr><td colspan=2>~0 torneigs celebrats aquesta temporada";
    }
  ?>
</table>
