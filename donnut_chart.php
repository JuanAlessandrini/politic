<?php

function createDonnutChart($idChart, $columnasName, $columnasTipo, $valores, $chartTitle, $toolTip){
//Crea Elemento para alojar grafico
$strReturn="";
$strReturn = "<div id='donutchart".$idChart."' class='chart_div' style=' float: left;'></div>";

//imprime codigo para visualizar grafico
$strReturn .= "<script>
     function drawChart".$idChart."() {
     var data = new google.visualization.DataTable();";

//Agrega Columnas
foreach($columnasName as $clave =>  $valor){
  $strReturn.="data.addColumn('".$columnasTipo[$clave]."', '$valor');";
}
if(sizeof($toolTip)>0){
  $strReturn.="data.addColumn({type: 'string', role: 'tooltip'});";
}
//Agrega filas de datos
$strReturn.="data.addRows([";
$cant=0;
foreach($valores as $fila){
  if($cant>0){$strReturn.=  ", ";}
    $strReturn.="[";
    $cantCampos = 0;
    foreach($fila as $campo){
      if($cantCampos  > 0){$strReturn.=", ";}
      if($columnasTipo[$cantCampos]=="string"){
        $strReturn.="'$campo'";
      }else{
        $strReturn.="$campo";
      }
      $cantCampos++;
    }
    if(sizeof($toolTip)>0){
      $strReturn.=", '$toolTip[$cant]'";
    }
    $strReturn.="]";
  $cant++;
}

$strReturn.="]);";

//Agrega opciones de visualizacion
$strReturn.="var options = {
 title: '".utf8_encode($chartTitle)."',
 pieHole: 0.4,
  animation:{
duration: 1000,
easing: 'out',
startup: true
}
};";

//Visualiza grafico
$strReturn.="var chart = new google.visualization.PieChart(document.getElementById('donutchart".$idChart."'));
chart.draw(data, options);
}";

//Llama funcion para visualizar grafico
$strReturn.="google.charts.load('current', {packages:['corechart']});
google.charts.setOnLoadCallback(drawChart".$idChart.");

</script>";

echo $strReturn;
}
 ?>
