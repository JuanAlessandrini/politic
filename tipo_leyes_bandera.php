
<?php
	$tipo = 3;
	$title = "Tipo de leyes con voto Afirmativo, por Bandera política";
	$subtitle = "Que inclinación política tienen nuestros representantes?";

	/*

		select a.*, b.party_id, b.legislator_id, b.region_id, b.vote FROM
(select id, left(voted_at,4) as anio, original_id, votings.type from votings) a INNER JOIN (select * from votings_votes)b ON a.id = b.voting_id

	*/

?>

<h3><?php echo $title; ?></h3>
<h5><?php echo $subtitle; ?></h5>
<?php
	include("sharer.php");

include("conexion.php");
$consulta="select c.party_Id, sum(c.cant) as cantidad,  c.type, d.name as partido from
(select a.*, b.anio, b.type from
(SELECT voting_id, party_id, vote, count(vote) as cant FROM politic.votings_votes group by voting_id, party_id, vote)a
INNER JOIN (SELECT id, type, left(voted_at, 4) as anio FROM politic.votings) b
ON b.id = a.voting_id) c
INNER JOIN (select id, name from parties) d
ON c.party_id = d.id
where c.anio > 2015 and c.vote = 'affirmative' and c.type <> 'Varios'
GROUP BY type, c.party_id
ORDER BY party_id";
$anio = 0;
$cant= 0;
$arrayScript = "";

$result = $conexion->query($consulta);
if($result->num_rows>0){
	while($row=$result->fetch_array()){
			if($anio!== $row[0]){

				if($cant>0){
					?>
					 <script>
							google.charts.load("current", {packages:["corechart"]});
							  google.charts.setOnLoadCallback(drawChart);
							  function drawChart() {
								var data = new google.visualization.DataTable();
								data.addColumn('string', 'Tipo');
								data.addColumn('number', 'Cantidad');
									data.addRows([
										<?php echo $arrayScript; ?>
								  ]);
							 var options = {
	          title: '<?php echo utf8_encode($row[3]); ?>',
	          pieHole: 0.4,
	           animation:{
					duration: 1000,
					easing: 'out',
					startup: true
				  }
	        };

	        var chart = new google.visualization.PieChart(document.getElementById('donutchart<?php echo $anio; ?>'));
	        chart.draw(data, options);
	      }
					</script>

					<?php

					$cant= 0;
					$arrayScript = "";
				}
				$anio = $row[0];
				echo "<div id='donutchart$anio' class='chart_div' style=' float: left;'></div>";

			}
			if($cant>0){$arrayScript.=  ", ";}
				$arrayScript.= "['$row[2]',  $row[1]]";
				$cant++;
		}
}else{echo"No se econtraron registros en $consulta";}
?>
