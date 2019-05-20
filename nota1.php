<?php

	$tipo = 5;
	$title = "Desafuero Julio De-Vido";
	$subtitle = "Mira como votaron nuestros representantes sobre la el desafuero de Julio De-Vido en la Honorable Camara de Diputados de la Nacion";
?>

<h3><?php echo $title; ?></h3>
<h5><?php echo $subtitle; ?></h5>
<?php
include("sharer.php");
include("conexion.php");
include("donnut_chart.php");

$consulta="select c.party_Id, sum(c.cant) as cantidad,  if(c.vote is null, 'Ausente', c.vote), d.name as partido from
(select a.*, b.anio, b.type from
(SELECT voting_id, party_id, vote, count(voting_id) as cant FROM politic.votings_votes group by voting_id, party_id, vote)a
INNER JOIN (SELECT id, type, left(voted_at, 4) as anio FROM politic.votings where id = 1896) b
ON b.id = a.voting_id) c
INNER JOIN (select id, name from parties) d
ON c.party_id = d.id
where c.anio > 2015 and c.type <> 'Varios'
GROUP BY type, c.party_id
ORDER BY c.vote";
$anio = 0;
$cant= 0;
$cantFilas = 0;
$graficos = "";
$arrayScript = "";
$valores = array();
$result = $conexion->query($consulta);
$columnasName = array("Partido", "Cantidad");
$columnasTipo = array("string", "number");
$cantVotos = 0;
$toolTip = "";
$filas = array();
	while($row=$result->fetch_array()){
    $anio=$row[2];
      if($cant>0){
        if($anio!== $curanio){
          $graficos .= createDonnutChart($cant, $columnasName, $columnasTipo, $filas, $curanio. " ($cantVotos votos)");
          unset($filas);
          $cantVotos = 0;
          $cantFilas = 0;
        }
        $curanio= $anio;
      }else{
        $curanio= $anio;
      }

        $filas[$cantFilas]= array($row[3], $row[1], '');
        $cantVotos += $row[1];
      $cantFilas++;
    $cant++;
}
echo $graficos;
 ?>
