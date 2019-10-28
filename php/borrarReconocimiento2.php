<?php
    session_start();
    include("./configBD.php");
    if(isset($_SESSION["usuario"])){
		$recon=$_POST["recon"];
		
		#$sqlBorrarReconocimiento = "delete from reconocimiento where reconocimiento='".$recon."'";
		$sqlBorrarReconocimiento = "call sp_borrarReconocimiento('".$recon."');";
		$resBorrarReconocimiento = mysqli_query($conexion, $sqlBorrarReconocimiento);
		$info = mysqli_affected_rows($conexion);
		echo $info;
		
	}else{
		header("location:./../index.php");
	}

?>