<?php
    session_start();
    include("./configBD.php");
    if(isset($_SESSION["numero_registros"])){
		$registros=$_SESSION["numero_registros"];
		$numero_registros=0;
		$total_registros=0;
		$sqlGetTotalGalardonado = "select count(*) as 'total' from vw_Galardonado;";
		$resGeTotaltGalardonado = mysqli_query($conexion,$sqlGetTotalGalardonado);
        while($total = mysqli_fetch_assoc($resGeTotaltGalardonado)){
			$total_s=$total["total"];
		}
		$total_registros=intval($total_s);
        $sqlGetGalardonado = "select * from vw_Galardonado;";
        $resGetGalardonado = mysqli_query($conexion,$sqlGetGalardonado);
		$jsonRespuesta = '{"filasGalardonado": "';
        while($galardonado = mysqli_fetch_assoc($resGetGalardonado)){
			if($numero_registros>=$registros){
				$jsonRespuesta .= "<tr id='r-".$numero_registros."' class='' data-rfc='".$galardonado["rfc"]."'>"
					."<td id='r-".$numero_registros."-1'>"
					.$galardonado["primer_apellido"]." ".$galardonado["segundo_apellido"]." "
					.$galardonado["nombre"]."</td><td id='r-".$numero_registros."-2'>".$galardonado["escuela"]
					."</td><td id='r-".$numero_registros."-3'>".$galardonado["reconocimiento"]."</td></tr>";
				}
			$numero_registros++;
			if($numero_registros==($registros+5)){
				break;
			}
        }
		$jsonRespuesta.='", "mostrarBotonMostrarMas":';
		if($numero_registros==$total_registros){
			$jsonRespuesta.='0}';
			unset($_SESSION["numero_registros"]);
		}else{
			$jsonRespuesta.='1}';
			$_SESSION["numero_registros"]=$numero_registros;
		}
		echo $jsonRespuesta;
		
	}
	
?>
