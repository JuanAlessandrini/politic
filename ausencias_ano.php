<?php
	$tipo = 5;
	$title = "Ausencias por año";
	$subtitle = "Cuanto trabajan nuestros representantes?";
?>

<h3><?php echo $title; ?></h3>
<h5><?php echo $subtitle; ?></h5>
<?php
	include("sharer.php");
?>

<div id="chart_div" class="chart_div"></div>
 <script>
 google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawTitleSubtitle);

function drawTitleSubtitle() {
      var data = google.visualization.arrayToDataTable([
        ['Año', 'Cantidad'],
<?php
		include("conexion.php");
		$cant= 0;
		$consulta="SELECT SUM(a.ausentes), a.anio FROM (SELECT absent_count as ausentes, left(voted_at, 4) as anio FROM politic.votings) a group by a.anio";
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
          title: 'Cantidad de Ausentes',
          subtitle: 'Basada en datos de la Honorable Camara de Diputados de la Nacion.'
        },
        hAxis: {
          title: 'Total',
          minValue: 0,
        },
        vAxis: {
          title: 'Año'
        },
        bars: 'horizontal',
         animation:{
			duration: 1000,
			easing: 'out',
			startup: true
		  }
      };
      var materialChart = new google.visualization.BarChart(document.getElementById('chart_div'));
      materialChart.draw(data, materialOptions);
    }

</script>
