<?php
	$tipo = 1;
	$title = "Proba el Simulador de votación que utiliza Machine Learning para predecir los resultados";
	$subtitle = "El simulador utiliza patrones del pasado para interpretar que votarian hoy los actuales representantes de nuestro pais, a partir de su bandera politica.";
?>

<h3>Simulador de votaciones Futuras</h3>
<h5><?php echo $subtitle; ?></h5>
<?php
	include("sharer.php");
?>

<p>Ingresa la decripcion de la ley a tratar:</p>
<input type="text" id="leyfutura" placeholder="Tratamiento - Exención de impuesto a las ganancias para jubilados y pensionados" />
<input type="button" class="btn primary get-result-votacion" value="Predecir resultado"/>
<div id="result-votacion"></div>

<script>

 $(".get-result-votacion").on("click", function(){
    	var ley = $("#leyfutura").val();
			if($("#learnWordFeedback")){
				var lwf = $("#learnWordFeedback").val();
			}else{
				var lwf="";
			}
    	var parametros = {"ley": ley, "lwf" : lwf};
    	$.ajax({
            url:   "get-simulador.php",
            type:  'POST',
            data : parametros ,
	            error: function(response){
            }
            ,
            beforeSend:function(){

             },
            success:  function (response) {
							$('#sharer').remove();
                $('#result-votacion').html(response);
            }
    });
});
</script>
