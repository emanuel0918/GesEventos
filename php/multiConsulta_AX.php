<?php
    session_start();
    include("./configBD.php");
    if(isset($_SESSION["numero_registros"])){
		$registros=$_SESSION["numero_registros"];
		$numero_registros=0;
		$total_registros=0;
		$sqlGetTotalAsistencia = "select count(*) as 'total' from vw_Asistencia;";
		$resGeTotaltAsistencia = mysqli_query($conexion,$sqlGetTotalAsistencia);
        while($total = mysqli_fetch_assoc($resGeTotaltAsistencia)){
			$total_s=$total["total"];
		}
		$total_registros=intval($total_s);
        $sqlGetAsistencia = "select * from vw_Asistencia;";
        $resGetAsistencia = mysqli_query($conexion,$sqlGetAsistencia);
		$jsonRespuesta = '{"filasAsistencia": "';
        while($asistencia = mysqli_fetch_assoc($resGetAsistencia)){
			if($numero_registros>=$registros){
				$jsonRespuesta .= "<tr id='r-".$numero_registros."'>"
					."<td id='r-".$numero_registros."-1'>"
					.$asistencia["primer_apellido"]." ".$asistencia["segundo_apellido"]." "
					.$asistencia["nombre"]."</td>";
					if($asistencia["asistencia"]==1){
						$jsonRespuesta.="<td id='r-".$numero_registros
						."-2' class='asistencia-si ver'".
						" data-staff='".$asistencia["staff"]."'"
						." data-usr='".$asistencia["usuario"]."'".
						" data-hora='".$asistencia["hora"]
						."'><i class='fa fa-check'></i></td></tr>";
					}else{
						$jsonRespuesta.="<td id='r-".$numero_registros."-2'>No</td></tr>";
					}
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