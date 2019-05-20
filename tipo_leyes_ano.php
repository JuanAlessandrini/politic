<?php
	$tipo = 2;
	$title = "Tipo de leyes aprobadas por año";
	$subtitle = "Que votan nuestros representantes?";

	/*

		select a.*, b.party_id, b.legislator_id, b.region_id, b.vote FROM
(select id, left(voted_at,4) as anio, original_id, votings.type from votings) a INNER JOIN (select * from votings_votes)b ON a.id = b.voting_id

	*/

?>

<h3><?php echo $title; ?></h3>
<h5><?php echo $subtitle; ?></h5>
<?php
	include("sharer.php");
?>

<?php
include("conexion.php");
$consulta="select b.anio, sum(cant), b.type from (select left(voted_at,4) as anio, count(original_id) as cant, votings.type from votings where result = 1 group by original_id) b where b.type <> 'Varios' group by b.anio, b.type order by b.anio desc";
$anio = 0;
$cant= 0;
$arrayScript = "";

$result = $conexion->query($consulta);
	while($row=$result->fetch_array()){
		if($anio!== $row[0]){

			if($cant>0){
				?>
				 <script>
						google.charts.load("current", {packages:["corechart"]});
						  google.charts.setOnLoadCallback(drawChart);
						  function drawChart() {
							var data = google.visualization.arrayToDataTable([
								['Tipo', 'Cantidad'],
									<?php echo $arrayScript; ?>
							  ]);
						 var options = {
							  'title': '<?php echo $anio; ?>',
							  'pieHole': 0.4,
							  'animation':{
									'duration': 1000,
									'easing': 'out','startup': true
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

?>
