<?php
$tipoLey = $_POST['tipo'];
include("conexion.php");
$consulta="select c.party_Id, sum(c.cant) as cantidad,  c.type, d.name as partido from
(select a.*, b.anio, b.type from
(SELECT voting_id, party_id, vote, count(vote) as cant FROM politic.votings_votes group by voting_id, party_id, vote)a
INNER JOIN (SELECT id, type, left(voted_at, 4) as anio FROM politic.votings) b
ON b.id = a.voting_id) c
INNER JOIN (select id, name from parties) d
ON c.party_id = d.id
where c.anio > 2015 and c.vote = 'affirmative' and c.type = '$tipoLey'
GROUP BY type, c.party_id
ORDER BY party_id";

$cant= 0;

?>
<script>
   google.charts.load("current", {packages:["corechart"]});
     google.charts.setOnLoadCallback(drawChart);
     function drawChart() {
     var data = new google.visualization.DataTable();
     data.addColumn('string', 'Tipo');
     data.addColumn('number', 'Cantidad');
       data.addRows([
      <?php
         $result = $conexion->query($consulta);
         if($result->num_rows>0){
         	 while($row=$result->fetch_array()){


             if($cant>0){echo  ", ";}
               echo "['$row[3]',  $row[1]]";
               $cant++;

         		}
         }else{
           echo"No se econtraron registros.";}
      ?>
       ]);
    var options = {
 title: 'Votaciones sobre leyes de orden a: <?php echo $tipoLey; ?>',
 pieHole: 0.4,
  animation:{
duration: 1000,
easing: 'out',
startup: true
}
};

var chart = new google.visualization.PieChart(document.getElementById('donutchart0'));
chart.draw(data, options);
}
</script>

<div id='donutchart0' class='chart_div' style=' float: left;'></div>
<?php

$consulta ="SELECT distinct document_url FROM politic.votings where type='$tipoLey'";
$result = $conexion->query($consulta);
if($result->num_rows>0){
  echo "<h5>Ver referencia a Leyes</h5>";
  while($row=$result->fetch_array()){
    echo "<a href='$row[0]' target='_blank'>$row[0]</a><br/>";
  }
}
?>
