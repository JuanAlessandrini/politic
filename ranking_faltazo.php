<?php
	$tipo = 6;
	$title = "Ranking del faltazo";
?>

<h3><?php echo $title; ?></h3>
<h5>Cuanto marcan tarjeta nuestros representantes?</h5>
<?php
	include("sharer.php");
?>

<div id="chart_div" class="chart_div3"></div>
 <script>
 google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawTitleSubtitle);

function drawTitleSubtitle() {
      var data = google.visualization.arrayToDataTable([
        ['Legislador', 'Cantidad'],
<?php
		include("conexion.php");
		$cant= 0;
		$consulta="select count(c.legislator_id) as cant, c.nombre
					from (SELECT a.legislator_id, b.nombre
							FROM politic.votings_votes a
							inner join (
								SELECT id, concat(last_name, ', ', name ) as nombre
								FROM politic.legislators) b
							on a.legislator_id = b.id
							where a.voting_id in (
								SELECT g.id
								FROM politic.votings g
								where g.voted_at > STR_TO_DATE('2016-01-01', '%Y-%m-%d'))
							and a.vote is null) c
					group by c.nombre
					ORDER BY cant desc LIMIT 100";
		$result = $conexion->query($consulta);
		while($row=$result->fetch_array()){
			if($cant>0){echo ", ";}
			echo "['".utf8_encode($row[1])."', $row[0]]";
			$cant++;
		}
?>
      ]);
  var materialOptions = {
        chart: {
          title: 'Cantidad de Faltazos',
          subtitle: 'Basada en datos de la Honorable Camara de Diputados de la Nacion.'
        },
        hAxis: {
          title: 'Total',
          minValue: 0,
        },
        vAxis: {
          title: 'Legislador'
        },
        bars: 'horizontal'
      };
      var materialChart = new google.charts.Bar(document.getElementById('chart_div'));
      materialChart.draw(data, materialOptions);
    }

</script>
