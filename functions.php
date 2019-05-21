<?php
function clasify($ley){
	$palabras_clave = array();
	$indice = -1;
	$palabras_asociadas = getArrayTipos($palabras_clave);
	$palabras_ley = explode(" ",$ley);
	$resultado = comparaArrays($palabras_ley, $palabras_asociadas, $indice);
	$cantClasif = sizeof($palabras_asociadas);
	if($indice>-1){
		return "$palabras_clave[$indice]";
	}else{
		return "Varios";
	}
}

function comparaArrays($array1, $array2, &$indice){
	$cantPalabras = sizeof($array2);
	for($i=0; $i<$cantPalabras; $i++){
		if($i > 200){break;}
		$coincidencias = array_uintersect($array1, $array2[$i], "strcasecmp");
		if(sizeof($coincidencias)>0){
			$indice = $i;
			break;
		}
	}
	return $coincidencias;

}
function clasifyHistoric(){
	include("conexion.php");
	$i=0;
	$consulta="select * from votings where type = 'Varios'";
	$result = $conexion->query($consulta);
		while($row=$result->fetch_array()){
			$ley = $row[6];
			$tipo = clasify($ley);
			$consulta="update votings set type = '$tipo' where id = $row[0]";
			if($conexion->query($consulta)){
				$i++;
			}
		}
	return "Cantidad procesados: $i";
}

function getArrayTipos(&$tipos){
	$consulta="select * from tags";
	$lastTag = "";
	$index = -1;
	if($result=$conexion->query($consulta)){
		if($result->num_rows>0){
			while($row=$result->fetch_array()){
				if($row<>$lastTag){
					$lastTag=$row[1];
					if($index>=0){
						$arrayMadre[$index] = $v1;
						unset($v1);
					}
					$index++;
					$tipos[$index] = $lastTag;
				}
				$v1 = array_push($row[2]);
			}
		}

	}
	/*
	$tipos[0] = "Tributario";
	$v1 = ["impuesto","impositiva", "impositivo", "impositivos","tributario", "tributarios", "tributaria"];
	$arrayMadre[0] = $v1;

	$tipos[1] = "Penal";
	$v1 = ["penal","pena","carcel","condena"];
	$arrayMadre[1] = $v1;

	$tipos[2] = "Constitucional";
	$v1 = ["reforma", "constitucional","constitución"];
	$arrayMadre[2] = $v1;

	$tipos[3] = "Codigo Electoral";
	$v1 = ["elector", "electoral"];
	$arrayMadre[3] = $v1;

	$tipos[4] = "Subsidios";
	$v1 = ["subsidio", "Subsidios"];
	$arrayMadre[4] = $v1;

	$tipos[5] = "Salud";
	$v1 = ["salud","medicina","hospital"];
	$arrayMadre[5] = $v1;

	$tipos[6] = "Educacion";
	$v1 = ["escuelas","educacion", "educación","enseñanza","universidad"];
	$arrayMadre[6] = $v1;

	$tipos[7] = "Comercio Exterior";
	$v1 = ["exportacion","importacion","nomenclatura"];
	$arrayMadre[7] = $v1;

	$tipos[8] = "Politica Monetaria";
	$v1 = ["banco central","cambiaria","moneda","encaje","bono","acciones"];
	$arrayMadre[8] = $v1;

	$tipos[9] = "Mercado Interno";
	$v1 = ["precio","consumo"];
	$arrayMadre[9] = $v1;

	$tipos[10] = "Derechos Humanos";
	$v1 = ["minoria","igualitar"];
	$arrayMadre[10] = $v1;

	$tipos[11] = "Laboral";
	$v1 = ["labor","trabajo","sindica","conciliacion"];
	$arrayMadre[11] = $v1;

	$tipos[12] = "Ley de Presupuesto";
	$v1 = ["presupuesto","general"];
	$arrayMadre[12] = $v1;

	$tipos[13] = "Judicial";
	$v1 = ["juicio"];
	$arrayMadre[13] = $v1;

	$tipos[14] = "Bienes Publicos";
	$v1 = ["transferencia"];
	$arrayMadre[14] = $v1;
*/
	return $arrayMadre;
}
function getVotacionDetails($tipo, $descripcion){
	include("conexion.php");
	$strResult = "";
	$strVotos="";
		//obtener % de afirmativo, negativo, abstenciones y ausentes por partido
		$consulta="select count(e.type) as CantVotos, e.vote as Tipo, e.party_id from
(SELECT a.* FROM politic.votings_votes a
inner join (
	select b.* from votings b where b.type = 'Constitucional' ) c
ON a.voting_id = c.id) e
group by e.vote, e.party_id";

//% de votos aff, neg, abs, y ausentes por bandera historicos, para x tipo de votacion:
$cons1= "select (x.CantVotos / z.cantleg) as porcentaje, x.party_id, IF(x.tipo is null, 'Ausente', x.tipo ) as TipoVotacion
								FROM
								(select count(e.type) as CantVotos, e.vote as Tipo, e.party_id from
								(SELECT a.* FROM politic.votings_votes a
								inner join (
									select b.* from votings b where b.type = '$tipo' ) c
								ON a.voting_id = c.id) e
								group by e.vote, e.party_id) x
								INNER JOIN

								(select count(r.type) as CantLeg, r.party_id from
								(SELECT t.* FROM politic.votings_votes t
								inner join (
								select u.* from votings u where u.type = '$tipo' ) y
								ON t.voting_id = y.id) r
								group by r.party_id) z

								on x.party_id = z.party_id";

// Cantidad de Legisladores que votaron .
$consulta1="select count(r.type) as CantLeg, r.party_id from
(SELECT t.* FROM politic.votings_votes t
inner join (
select u.* from votings u where u.type = 'Constitucional' ) y
ON t.voting_id = y.id) r
group by r.party_id";

		//obtener cantidad de diputados por bandera.
		$consulta2="select e.party_id, count(e.legislator_id) from
(SELECT distinct a.party_id, a.legislator_id FROM politic.votings_votes a
inner join (
	select b.* from votings b where b.voted_at > STR_TO_DATE('2018-10-01', '%Y-%m-%d') ) c
ON a.voting_id = c.id) e
group by e.party_id";


		// aplicar a diputados que votaron desde el 2017 por bandera Politica
		$consulta = "select j.votos, j.tipovotacion, h.name from
(select round(l.cleg * k.porcentaje) as votos, k.party_id, k.tipovotacion

FROM
(select e.party_id, count(e.legislator_id) as cleg from
(SELECT distinct a.party_id, a.legislator_id FROM politic.votings_votes a
inner join (
	select b.* from votings b where b.voted_at > STR_TO_DATE('2018-10-01', '%Y-%m-%d') ) c
ON a.voting_id = c.id) e
group by e.party_id) l
inner JOIN
(select (x.CantVotos / z.cantleg) as porcentaje, x.party_id, IF(x.tipo is null, 'Ausente', x.tipo ) as TipoVotacion
FROM
(select count(e.type) as CantVotos, e.vote as Tipo, e.party_id from
(SELECT a.* FROM politic.votings_votes a
inner join (
	select b.* from votings b where b.type = '$tipo' ) c
ON a.voting_id = c.id) e
group by e.vote, e.party_id) x
INNER JOIN

(select count(r.type) as CantLeg, r.party_id from
(SELECT t.* FROM politic.votings_votes t
inner join (
select u.* from votings u where u.type = '$tipo' ) y
ON t.voting_id = y.id) r
group by r.party_id) z

on x.party_id = z.party_id) k

on k.party_id = l.party_id) j
INNER JOIN parties h
ON j.party_id = h.id
order by h.name";

		//devolver resultado general

		$votAF = 0;
		$votNE = 0;
		$votAB = 0;
		$votAU = 0;

$colVoto = array();
$partidoVoto = "";
$cant = 0;

	$tipo = 1;
	$title = "Mira los resultados de la simulacion de la siguiente votacion: $descripcion";
	$subtitle = "El simulador utiliza patrones del pasado para interpretar que votarian hoy los actuales representantes de nuestro pais, a partir de su bandera politica.";
include("sharer.php");
		$strVotos="<table id='votationDetail'><thead><tr><th>Partido</th><th>Afirmativos</th><th>Negativos</th><th>Abstenciones</th><th>Ausencias</th></tr></thead>";
		if($result = $conexion->query($consulta)){

				while($row=$result->fetch_array()){
					if($cant>0){
						if($row[2]!==$partidoVoto){
							$strVotos.="<tr><td>".utf8_encode($partidoVoto)."</td><td>$colVoto[0]</td><td>$colVoto[1]</td><td>$colVoto[2]</td><td>$colVoto[3]</td></tr>";
							$partidoVoto = $row[2];
						}
					}else{
						$partidoVoto = $row[2];
					}

					switch($row[1]){
						case "abstention":
							$votAB += $row[0];
							$colVoto[2] = $row[0];
							break;
						case "affirmative":
							$votAF += $row[0];
							$colVoto[0] = $row[0];
							break;
						case "negative":
							$votNE += $row[0];
							$colVoto[1] = $row[0];
							break;
						case "Ausente":
							$votAU += $row[0];
							$colVoto[3] = $row[0];
							break;
					}
					$cant++;
				}
				$strResult = "<div id='contentVotation'>
						<div class='section affirmative'><p>$votAF</p><a>Afirmativos</a></div>
						<div class='section negative'><p>$votNE</p><a></a>Negativos</div>
						<div class='section abstention'><p>$votAB</p><a>Abstenciones</a></div>
						<div class='section Ausente'><p>$votAU</p><a>Ausentes</a></div>
				</div>";
		}
		return $strResult.$strVotos;
}
/*


	Tributario
	Penal
	Constitucional
	Codigo Electoral
	Seguridad Social
	Salud
	Educacion
	Derecho Internacional
	Comercio Exterior
	Politica Monetaria
	Mercado Interno
	Derechos Humanos
	Laboral


*/
?>
