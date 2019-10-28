<?php

class GenerarPdf{
    function __construct(){
		require_once __DIR__ . '/vendor/autoload.php';
	}
	function generar_invitacion($rfc,$nombre,$primerApe,$segundoApe,$recon,$escuela,$token){
		$s1=strtolower($recon);
		$s2="diplomas";
		$s3="diploma";
		$s4="presea";
		$s5="reconocimiento";
		$s5="premio";
		$e1=strtolower($escuela);
		$e2="cecyt";
		$mensaje='';
		if (strpos($s1,$s2)!==false) {
			if (strpos($e1,$e2)!==false) {
				$mensaje='Por medio de la presente le hacemos de saber a usted '
						.'<label class="negrita">'.$nombre.' '.$primerApe.' '.$segundoApe
						.'</label> conocer que usted ser&aacute; galardonado ganador de uno de los '
						.$recon.' como m&eacute;rito polit&eacute;cnico por sus servicios al '
						.$escuela.' de nuestra prestigiosa instituci&oacute;n.';
			}else{
				$mensaje='Por medio de la presente le hacemos de saber a usted '
						.'<label class="negrita">'.$nombre.' '.$primerApe.' '.$segundoApe
						.'</label> conocer que usted ser&aacute; galardonado ganador de uno de los '
						.$recon.' como m&eacute;rito polit&eacute;cnico por sus servicios a la '
						.$escuela.' de nuestra prestigiosa instituci&oacute;n.';
			}
		}else if (strpos($s1,$s3)!==false) {
			if (strpos($e1,$e2)!==false) {
				$mensaje='Por medio de la presente le hacemos de saber a usted '
						.'<label class="negrita">'.$nombre.' '.$primerApe.' '.$segundoApe
						.'</label> conocer que usted ser&aacute; galardonado ganador del '
						.$recon.' como m&eacute;rito polit&eacute;cnico por sus servicios al '
						.$escuela.' de nuestra prestigiosa instituci&oacute;n.';
			}else {
				$mensaje='Por medio de la presente le hacemos de saber a usted '
						.'<label class="negrita">'.$nombre.' '.$primerApe.' '.$segundoApe
						.'</label> conocer que usted ser&aacute; galardonado ganador del '
						.$recon.' como m&eacute;rito polit&eacute;cnico por sus servicios a la '
						.$escuela.' de nuestra prestigiosa instituci&oacute;n.';
			}
		}else if (strpos($s1,$s4)!==false) {
			if (strpos($e1,$e2)!==false) {
				$mensaje='Por medio de la presente le hacemos de saber a usted '
						.'<label class="negrita">'.$nombre.' '.$primerApe.' '.$segundoApe
						.'</label> conocer que usted ser&aacute; galardonado ganador de la '
						.$recon.' como m&eacute;rito polit&eacute;cnico por sus servicios al '
						.$escuela.' de nuestra prestigiosa instituci&oacute;n.';
			}else{
				$mensaje='Por medio de la presente le hacemos de saber a usted '
						.'<label class="negrita">'.$nombre.' '.$primerApe.' '.$segundoApe
						.'</label> conocer que usted ser&aacute; galardonado ganador de uno de la '
						.$recon.' como m&eacute;rito polit&eacute;cnico por sus servicios a la '
						.$escuela.' de nuestra prestigiosa instituci&oacute;n.';
			}
		}else  {
			if (strpos($e1,$e2)!==false) {
				$mensaje='Por medio de la presente le hacemos de saber a usted '
						.'<label class="negrita">'.$nombre.' '.$primerApe.' '.$segundoApe
						.'</label> conocer que usted ser&aacute; galardonado ganador del '
						.$recon.' como m&eacute;rito polit&eacute;cnico por sus servicios al '
						.$escuela.' de nuestra prestigiosa instituci&oacute;n.';
			}else{
				$mensaje='Por medio de la presente le hacemos de saber a usted '
						.'<label class="negrita">'.$nombre.' '.$primerApe.' '.$segundoApe
						.'</label> conocer que usted ser&aacute; galardonado ganador de uno del '
						.$recon.' como m&eacute;rito polit&eacute;cnico por sus servicios a la '
						.$escuela.' de nuestra prestigiosa instituci&oacute;n.';
			}
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
			<div class="invitacion-contenido">
			<div class="row">
			<div class="col-8">
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
				<br>
				<br>
				<br>
				<p class="class-flow justify sangrado">'.$mensaje.'</p>
			</div>
			<div class="col-3 centrado">
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
				<br>
				<br>
				<br>
				<br>
				<br>
				<img src="tokens/'.$token.'.png" class="qr">
				<br>
				<p class="texto-centrado">FOLIO:'.$token.'</p>
			</div>
			</div>
			</div>
			</body>
		</html>
		');
		$mpdf->Output('invitaciones/'.$rfc.'.pdf','F');
		#$mpdf->Output();
	}
}
?>