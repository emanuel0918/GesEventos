<?php

	require_once __DIR__ . '/vendor/autoload.php';
    include("./configBD.php");
	$rfc=$_GET["rfc"];
	$sqlGetPDF = "select vw_PDF where rfc='".$rfc."';";
	$resGetPDF = mysqli_query($conexion,$sqlGetPDF);
	while($GetPDF = mysqli_fetch_assoc($resGetPDF,MYSQLI_BOTH)){
		$nombre=$GetPDF["nombre"];
		$token=$GetPDF["token"];
	}
	$mpdf = new \Mpdf\Mpdf([
		'mode' => 'utf-8',
		'format' => 'A4-L',
		'orientation' => 'L'
	]);
	$mpdf->WriteHTML('<!DOCTYPE html>
	<html>
		<head>
			<link href="./../css/invitacion/invitacion.css" rel="stylesheet">
			<link href="./../css/materialize/css/materialize.min.css" rel="stylesheet">
		</head>
		<body>
			<div class="contenido">
			<div class="invitacion-texto">
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<p class="class-flow justify">'.$mensaje.'
			</p>
			<br>
			<br>
			</div>
			<div class="invitacion-extra">
				<div class="invitacion-extra-left">
				</div>
				<div class="invitacion-extra-right">
				<img src="tokens/'.$token.'.png" width="100%" height="100%">
				</div>
			</div>
			</div>
		</body>
	</html>
	');
	$mpdf->Output();
?>