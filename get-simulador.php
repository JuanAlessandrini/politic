



<?php
	include("conexion.php");
	include("functions.php");

	$ley = $_POST['ley'];
	$lwf = $_POST['lwf'];
	if($lwf==""){
		$tipo = clasify($ley);
	}else{
		$tipo = $lwf;
	}
	echo $tipo;
	if($tipo!=="Varios"){
		echo getVotacionDetails($tipo, $ley);
	}else{
		echo "<p>No hemos podido identificar el tipo de Ley...</p>Por favor, enseñale a nuestro bot, que tipo de ley trata:
		<select id='learnWordFeedback'>
			<option>Penal</option>
			<option>Constitucional</option>
			<option>Codigo Electoral</option>
			<option>Subsidios</option>
			<option>Salud</option>
			<option>Educacion</option>
			<option>Comercio Exterior</option>
			<option>Politica Monetaria</option>
			<option>Mercado Interno</option>
			<option>Derechos Humanos</option>
			<option>Laboral</option>
			<option>Ley de Presupuesto</option>
			<option>Judicial</option>
			<option>Bienes Publicos</option>
			<option>Otra</option>
		</select>";
	}





?>
