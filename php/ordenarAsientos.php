<?php

class OrdenarAsientos
{
	function ordenarLosAsientos(){
		include("./configBD.php");
		$sqlVerAsistencia = "select count(*) as 'asistencia' from asistencia where asistencia=1;";
		$resVerAsistencia = mysqli_query($conexion,$sqlVerAsistencia);
		$hayAsistencia=0;
		while($asistencia = mysqli_fetch_assoc($resVerAsistencia)){
			$hayAsistencia=intval($asistencia["asistencia"]);
		}
		if($hayAsistencia==0){
			$idasiento=1;
			$idgal=1;
			$sqlGalardonadosDiscapacitados = "select * from vw_Galardonado where discapacidad =1 order by reconocimiento, primer_apellido;";
			$resGalardonadosDiscapacitados = mysqli_query($conexion,$sqlGalardonadosDiscapacitados);
			while($galardonadosDiscapacitados = mysqli_fetch_assoc($resGalardonadosDiscapacitados)){
				$idgal=intval($galardonadosDiscapacitados["idgal"]);
				$sqlAgregarRelacionAsiento = "insert into rel_asiento_galardonado(idasiento,idgal)values("
				.$idasiento.",".$idgal.");";
				mysqli_query($conexion,$sqlAgregarRelacionAsiento);
				$sqlOcuparAsiento = "update asiento set ocupado=1 where idasiento=".$idasiento.";";
				mysqli_query($conexion,$sqlOcuparAsiento);
				$idasiento++;
			}
			
			$sqlGalardonadosNoDiscapacitados = "select * from vw_Galardonado where discapacidad =0 order by reconocimiento, primer_apellido;";
			$resGalardonadosNoDiscapacitados = mysqli_query($conexion,$sqlGalardonadosNoDiscapacitados);
			while($galardonadosNoDiscapacitados = mysqli_fetch_assoc($resGalardonadosNoDiscapacitados)){
				$idgal=intval($galardonadosNoDiscapacitados["idgal"]);
				$sqlAgregarRelacionAsiento = "insert into rel_asiento_galardonado(idasiento,idgal)values("
				.$idasiento.",".$idgal.");";
				mysqli_query($conexion,$sqlAgregarRelacionAsiento);
				$sqlOcuparAsiento = "update asiento set ocupado=1 where idasiento=".$idasiento.";";
				mysqli_query($conexion,$sqlOcuparAsiento);
				$idasiento++;
			}
			
		}
		
	}
}

?>