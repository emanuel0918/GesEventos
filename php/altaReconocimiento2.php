<?php
    session_start();
    include("./configBD.php");
    if(isset($_SESSION["usuario"])){
		$recon=$_POST["recon"];
		$info=0;
		
		$sqlGetTipoRecon = "select f_idReconocimiento('".$recon."');";
		$resGetTipoRecon = mysqli_query($conexion,$sqlGetTipoRecon);
		$info = mysqli_affected_rows($conexion);
		echo $info;
		
	}else{
		header("location:./../index.php");
	}
	
?>