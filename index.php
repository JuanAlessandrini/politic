
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"/>
<title>JAS | Politic</title>
<meta name="description" content="Acceso a Ciudadanos"/>
<meta name="keywords" content="JAS | Polis"/>
<meta http-equiv="Content-Type"content="text/html; charset=UTF-8"/>
<meta name="revisit-after" content="14 days"/>
<meta name="robots" content="index,follow"/>
<meta name="distribution" content="global"/>
<meta http-equiv="Expires" content="0"/>
  <meta http-equiv="Last-Modified" content="0"/>
  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate"/>
  <meta http-equiv="Pragma" content="no-cache"/>
<link rel="shortcut icon" type="image/x-icon" href="/apps/images/congress.png" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta property="og:title" content="Politics" />
    <meta id="fbdescription" property="og:description" content="Que y como votan nuestros representantes" />
    <meta property="og:image" content="https://www.jas-software.com.ar/apps/politic/images/grafico.png" />
    <meta property="og:url" content="https://www.jas-software.com.ar/apps/politic/" />



<!--FUENTES
<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'/>-->
<!-- ESTILOS-->
<link href="/jquery-ui-1.12.1.custom/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="/jquery-ui-1.12.1.custom/jquery-ui.theme.css" rel="stylesheet" type="text/css" />
<link href="/apps/politic/css/wizard.css?version=15" rel="stylesheet" type="text/css" />

<!--FUNCIONAMIENTO JQUERY-->

<script charset="utf-8" type="text/javascript" src="/js/jquery.min.js"></script>
<script charset="utf-8" type="text/javascript" src="/js/jquery-ui.min.js"></script>
<script charset="utf-8" type="text/javascript" src="/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>

  <?php include("header.php"); ?>

    <p class="leyend">Información descargada de la Honorable Camara de Dipuados de la Nación.</p>
   <div id="content">
      <?php include("menu.php"); ?>

        <div id="contCentral" class="columna"  style="width: 70%; padding:5px;"></div>
        <div id="irArriba" style="position:fixed; width:60px; height:60px; right: 5px; top: 580px; background: url('/images/top-page.png') no-repeat; background-size: contain;cursor:pointer;"></div>
	</div>

</body>

</html>
<?php

/* Relacion de las tablas:

votings
	|
	| (id
	|    voting_id)
	|
	|_> votings_records
	           |
	           | (id
			   |    voting_id)
			   |
	           |_>  voting_votes
	           			|
	           			|_>   legislators
	           			|
	           			|_>   parties
	           			|
	           			|_>   regions



*/




?>
