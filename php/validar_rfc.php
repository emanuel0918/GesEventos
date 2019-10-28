<?php
    session_start();

	$rfc = $_POST['rfc'];
	$valido =1;
	$dia=intval(substr($rfc,8,2));
	$mes= intval(substr($rfc,6,2));
	if(!($mes>=1 && $mes<=12)){
		$valido=0;
	}else{
		if($mes== 1 || $mes ==3 || $mes==5 || $mes==7 || $mes==8 
			|| $mes==10 || $mes==12){
			if(!($dia>=1 && $dia<=31)){
				$valido=0;
			}
		}
		if($mes== 4 || $mes ==6 || $mes==9 || $mes==11){ 
			if(!($dia>=1 && $dia<=30)){
				$valido=0;
			}
		}
		if($mes==2){
			if(!($dia>=1 && $dia<=29)){
				$valido=0;
			}
		}
	}

	for($i=4;$i<10;$i++){
		if(!($rfc[$i]>='0' && $rfc[$i] <= '9')){
			$valido=0;
		}
	}
	if ($valido==1) {

		echo $valido;

	}else{

		echo $valido;

	}
?>
