



<?php
	include("conexion.php");
	include("functions.php");

	$ley = $_POST['ley'];
	$lwf = $_POST['lwf'];
	$newType = $_POST['nt'];
	if($lwf==""){
		$tipo = clasify($ley);
	}else{
		$tipo = $lwf;
		learnLawClasification($tipo, $ley, $newType);
		//echo "Ley '$ley' aprendida como $tipo";
	}

	if($tipo!=="Varios"){
		echo getVotacionDetails($tipo, $ley);
	}else{
		echo "<p>No hemos podido identificar el tipo de Ley...</p>Por favor, enseñale a nuestro bot, que tipo de ley trata:
		<select id='learnWordFeedback'>";

		$consulta="select * from tipo_clasification order by id DESC";
		if($result = getQueryResult($consulta)){
			while($row=$result->fetch_array()){
				echo "<option value='$row[1]'>$row[1]</option>";
			}
		}

		echo "</select>";
	}





?>
