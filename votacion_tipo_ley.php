<?php
	$tipo = 3;
	$title = "Votacion por tipo de Ley";
	$subtitle = "Selecciona el tipo de ley para ver que fuerzas estuvieron a favor de su aprobacion.";

?>

<h3><?php echo $title; ?></h3>
<h5><?php echo $subtitle; ?></h5>
<?php
	include("sharer.php");
?>
<div><select id="selLawType">
<?php
  include("conexion.php");
  $consulta="select distinct type from votings where type <> 'Varios'";
  $result=$conexion->query($consulta);
  while($row=$result->fetch_array()){
    echo "<option value='$row[0]'>$row[0]</option>";
  }
 ?>
</select><input type="button" id="btnGetResult" class="btn" value="Consultar"/></div>
<div id="result"></div>
<script>
$("#btnGetResult").on("click", function(){
  var tipo = $("#selLawType").val();
  var parametros = {"tipo": tipo};
  $.ajax({
  url:   "votacion_tipo_ley_result.php",
  type:  'POST',
  data: parametros,
  error: function(response){
  }
  ,
  beforeSend:function(){
   },
  success:  function (response) {
    $('#result').html(response);
  }
  });

});
</script>
