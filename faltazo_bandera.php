
<?php
	$tipo = 7;
	$title = "Ranking medido a partir del 01/01/2016";
	$subtitle = "Cuales son los partidos que mejor asistencia tienen al recinto?";
?>

<h3><?php echo $title; ?></h3>
<h5><?php echo $subtitle; ?></h5>
<?php
	include("sharer.php");
?>
<div id="chart_div"   class="chart_div3"></div>
 <script>
 google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawTitleSubtitle);

function drawTitleSubtitle() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Partido');
        data.addColumn('number','Cantidad');
        data.addRows([
<?php

		include("conexion.php");
		$cant= 0;
		$consulta="select ROUND(count(legislador)/tot_leg) as promedio, partido from (
					select w.last_name as legislador, w.nombre as partido, z.tot_leg from
					(select d.*, e.name, e.last_name, f.name as nombre from (select c.id, c.legislator_id, c.party_id, c.voting_id, c.vote from votings_votes c) d
						INNER JOIN
									(select a.id from votings a where a.voted_at > STR_TO_DATE('2016-01-01', '%Y-%m-%d')) b
						ON
							b.id = d.voting_id
						INNER JOIN
							legislators e
						ON
							d.legislator_id = e.id
						INNER JOIN
							parties f
						ON
							d.party_id = f.id) w
					INNER JOIN
					(select count(h.legislator_id) as tot_leg, h.party_id from(
					select distinct g.legislator_id, g.party_id from (
					select d.*, e.name, e.last_name, f.name as nombre from (select c.id, c.legislator_id, c.party_id, c.voting_id, c.vote from votings_votes c) d
						INNER JOIN
									(select a.id from votings a where a.voted_at > STR_TO_DATE('2016-01-01', '%Y-%m-%d')) b
						ON
							b.id = d.voting_id
						INNER JOIN
							legislators e
						ON
							d.legislator_id = e.id
						INNER JOIN
							parties f
						ON
							d.party_id = f.id) g

					) h
					group by h.party_id) z

					ON w.party_id = z.party_id

					where w.vote is null) k
					GROUP BY k.partido
					ORDER BY promedio DESC";



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
          title: 'Cantidad de Faltazos por Bandera Política',
          subtitle: 'Promedio de faltazos en base a la cantidad de legisladores con banca en el parlamento.'
        },
        hAxis: {
          title: 'Total',
          minValue: 0,
        },
        vAxis: {
          title: 'Partido'
        },
         animation:{
			duration: 1000,
			easing: 'out',
			startup: true
		  },
        bars: 'horizontal'
      };
      var materialChart = new google.visualization.BarChart(document.getElementById('chart_div'));
      materialChart.draw(data, materialOptions);
    }

</script>
