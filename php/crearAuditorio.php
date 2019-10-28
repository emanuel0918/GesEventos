<?php

class CrearAuditorio
{
	#el verdadero ancho del auditorio es $anchoAuditorio -1
	var $anchoAuditorio=20;
	#el verdadero alto del auditorio es $altoAuditorio -2
	var $altoAuditorio=7;
	var $nombreAuditorio="auditorio";
	
    function __construct(){
		include("./configBD.php");
		$sqlBorrarAuditorio = "call sp_borrarAuditorio('".$this->nombreAuditorio."');";
		mysqli_query($conexion,$sqlBorrarAuditorio);
		$fila;
		$es_asiento=0;
		for($i=64;$i<67;$i++){
			$fila=chr($i);
			for($j=1;$j<$this->anchoAuditorio;$j++){
				$sqlCrearAsiento = "call sp_crearAsiento('".$this->nombreAuditorio
				."','".$fila."',".$j.",1,1);";
				mysqli_query($conexion,$sqlCrearAsiento);
			}
		}
		for($i=67;$i<(67+$this->altoAuditorio);$i++){
			$fila=chr($i);
			for($j=1;$j<$this->anchoAuditorio;$j++){
				$es_asiento=$j%2;
				$sqlCrearAsiento = "call sp_crearAsiento('".$this->nombreAuditorio
				."','".$fila."',".$j.",".$es_asiento.",0);";
				mysqli_query($conexion,$sqlCrearAsiento);
			}
		}
		
    }
}
?>