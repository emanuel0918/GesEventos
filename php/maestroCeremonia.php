<?php
    session_start();
	require_once __DIR__ . '/vendor/autoload.php';
    include("./configBD.php");
    if(isset($_SESSION["usuario"])){
		$mensaje='Por medio de este contenido se presentan al maestro de ceremnon&iacute;as los presentes galardonados:';
		$escuelas =array();
		$id=0;
		$hayRegistros=0;
		$entregado1_s='';
		$entregado2_s='';
        $sqlGetEscuela = "select * from escuela;";
        $resGetEscuela = mysqli_query($conexion,$sqlGetEscuela);
        while($esc = mysqli_fetch_array($resGetEscuela,MYSQLI_BOTH)){
			array_push($escuelas,$esc[1]);
		}
		
		$html_galardonados='<table class="pdf-maestro-tabla"><tbody>';
		foreach ($escuelas as $escuela) {
			$hayRegistros=0;
			$sqlGetGalardonado = "select * from vw_Asistencia where escuela='"
			.$escuela."' order by segundo_apellido;";
			$resGetGalardonado = mysqli_query($conexion,$sqlGetGalardonado);
			while($galardonados = mysqli_fetch_assoc($resGetGalardonado)){
				$entregado1_s=strtolower($galardonados["observaciones"]);
				$entregado2_s="entregado";
				if($hayRegistros==0){
					$html_galardonados.='<tr>'
					.'<td class="pdf-maestro-escuela" colspan="3">'.$escuela
					.'</td></tr><tr><td class="pdf-maestro-header">Id</td>'
					.'<td class="pdf-maestro-header">Galardonado</td>'
					.'<td class="pdf-maestro-header">Observaciones</td></tr>';
				}
				if($galardonados["asistencia"]==0 || $galardonados["asistencia"]=='0'){
					if (strpos($entregado1_s,$entregado2_s)!==false) {
						$html_galardonados.='<tr><td class="pdf-maestro-no-asistio">'.$galardonados["idgal"]
						.'</td><td class="pdf-maestro-no-asistio">'.$galardonados["primer_apellido"]
						.' '.$galardonados["segundo_apellido"].' '.$galardonados["nombre"]
						.'</td><td class="pdf-maestro-entregado">'.$galardonados["observaciones"].'</td></tr>';
					}else{
						$html_galardonados.='<tr><td class="pdf-maestro-no-asistio">'.$galardonados["idgal"]
						.'</td><td class="pdf-maestro-no-asistio">'.$galardonados["primer_apellido"]
						.' '.$galardonados["segundo_apellido"].' '.$galardonados["nombre"]
						.'</td><td class="pdf-maestro-no-entregado">'.$galardonados["observaciones"].'</td></tr>';
					}
					
				}else{
					if (!strpos($entregado1_s,$entregado2_s)!==false) {
						$html_galardonados.='<tr><td class="pdf-maestro-si-asistio">'.$galardonados["idgal"]
						.'</td><td class="pdf-maestro-si-asistio">'.$galardonados["primer_apellido"]
						.' '.$galardonados["segundo_apellido"].' '.$galardonados["nombre"]
						.'</td><td class="pdf-maestro-entregado">'.$galardonados["observaciones"].'</td></tr>';
					}else{
						$html_galardonados.='<tr><td class="pdf-maestro-si-asistio">'.$galardonados["idgal"]
						.'</td><td class="pdf-maestro-si-asistio">'.$galardonados["primer_apellido"]
						.' '.$galardonados["segundo_apellido"].' '.$galardonados["nombre"]
						.'</td><td class="pdf-maestro-no-entregado">'.$galardonados["observaciones"].'</td></tr>';
					}
				}
				$hayRegistros++;
			}
			$html_galardonados.='';
		}
		$html_galardonados.='</tbody></table><br><br>';
		
		
		


	$mpdf = new Mpdf\Mpdf();

	$mpdf->SetHeader('Maestro de Ceremon&iacute;as');
	$html = '
	<html>
	<head>
	<link href="./../css/pdf/pdf_maestro.css" rel="stylesheet">
	</head>

	<body><div class="container"><div class="row pdf-maestro-intro">
	<p class="pdf-maestro-mensaje">'.$mensaje.'</p>
	</div>
		<div class="row">
		'.$html_galardonados.'
		</div>
		</div>
	</body>
	</html>';

	#echo $html;
	$mpdf->WriteHTML($html);

	$mpdf->Output();
	}
?>
