<?php 
	$tipo = 4; 
	$title = "Cantidad de sesiones realizadas por año";
	$subtitle = "Cuanto trabajan nuestros representantes?";
?>
		
<h3><?php echo $title; ?></h3>
<h5><?php echo $subtitle; ?></h5>
<?php
	include("sharer.php");
?>

<div id="chart_div" style="width: 900px; height: 500px;"></div>
 <script>
 google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawTitleSubtitle);

function drawTitleSubtitle() {
      var data = new google.visualization.DataTable();
      	data.addColumn('string', 'Año');
        data.addColumn('number','Cantidad');
        data.addRows([
<?php
		include("conexion.php");
		$cant= 0;
		$consulta="SELECT COUNT(a.original_id), a.anio FROM (SELECT distinct original_id, left(voted_at, 4) as anio FROM politic.votings where result = 1) a group by a.anio";
		$result = mysql_query($consulta, $conexion);
		while($row=mysql_fetch_row($result)){
			if($cant>0){echo ", ";}
			echo "['$row[1]', $row[0]]";
			$cant++;
		}
?>
      ]);
  var materialOptions = {
        chart: {
          title: 'Cantidad de leyes Aprobadas',
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