<div id="contenedorMenu" class="columna" style="width: 25%;">
  <a class="item" data-dest="simulador">Simulador de votación futura</a>
  <a class="item" data-dest="tipo_leyes_ano">Tipos de Leyes por Año</a>
  <a class="item" data-dest="tipo_leyes_bandera">Tipos de Leyes por Bandera Politica</a>
  <a class="item" data-dest="votaciones_ano">Cuantas votaciones se realizaron por año?</a>
  <a class="item" data-dest="ausencias_ano">Cuantas Ausencias hubo por año?</a>
  <a class="item" data-dest="ranking_faltazo">Ranking del faltazo</a>
  <a class="item" data-dest="faltazo_bandera">Faltazos por Bandera Política</a>
  <a class="item" data-dest="comparacion_anual">Cantidad de leyes sancionadas por año</a>
  <a class="item" data-dest="votacion_tipo_ley">Votaciones por Tipo de Ley</a>
  <a href="mailto:jas.softwares@gmail.com">... proponé tu reporte!</a>
</div>

<script>
function getPage(page){
$.ajax({
url:   page+".php",
type:  'POST',

error: function(response){

}
,
beforeSend:function(){

 },
success:  function (response) {

  $('#contCentral').html(response);
  $("span.loading").each(function(){
    $(this).remove();
  });
}
});

}
<?php
$page = "";
if(isset($_GET['v'])){
$tipo = $_GET['v'];
switch($tipo){
case "1":
  $page="simulador";
  break;
case "2":
  $page="tipo_leyes_ano";
  break;
case "3":
  $page="tipo_leyes_bandera";
  break;
case "4":
  $page="votaciones_ano";
  break;
case "5":
  $page="ausencias_ano";
  break;
case "6":
  $page="ranking_faltazo";
  break;
case "7":
  $page="faltazo_bandera";
  break;
case "8":
  $page="comparacion_anual";
  break;
  case "9":
    $page="votacion_tipo_ley";
    break;
default:
$page="portal";
  break;
}
echo "getPage('$page');";
}else{
  if(!isset($_GET['id'])){echo "getPage('portal');";}

}
?>

$("#contenedorMenu>a.item").on("click", function(){
var dest = $(this).attr("data-dest");
$(this).append("<span class='loading'></span>");
getPage(dest);
    closeMenu();
});

$("#contCentral").on("click", function(){
closeMenu();
});
$("i.menu").on("click", function(){
var posi = $("#contenedorMenu").css("left");

if(posi=="0px"){
closeMenu();
}else{
openMenu();
}
});

function closeMenu(){
$("#contenedorMenu").css("left", "-70%");
}
function openMenu(){
$("#contenedorMenu").css("left", "0px");
}
</script>
