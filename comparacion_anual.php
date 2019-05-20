 <div id="chart_div"  class="chart_div2"></div>
 <script>
 google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawTitleSubtitle);

function drawTitleSubtitle() {
      var data = google.visualization.arrayToDataTable([
        ['Año', 'Cantidad'],
<?php
		include("conexion.php");
		$cant= 0;
		$consulta="SELECT COUNT(a.original_id), a.anio FROM (SELECT distinct original_id, left(voted_at, 4) as anio FROM politic.votings) a group by a.anio";
		$result = $conexion->query($consulta);
		while($row=$result->fetch_array()){
			if($cant>0){echo ", ";}
			echo "['$row[1]', $row[0]]";
			$cant++;
		}
?>
      ]);
  var materialOptions = {
        chart: {
          title: 'Cantidad de leyes votadas',
          subtitle: 'Basada en datos de la Honorable Camara de Diputados de la Nacion.'
        },
        hAxis: {
          title: 'Total',
          minValue: 0,
        },
        vAxis: {
          title: 'Año'
        },
        bars: 'vertical'
      };
      var materialChart = new google.charts.Bar(document.getElementById('chart_div'));
      materialChart.draw(data, materialOptions);
    }

</script>
