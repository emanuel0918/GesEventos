<?php
    session_start();
    include("./configBD.php");
    if(isset($_SESSION["usuario"])){
		$escuela=$_POST["escuela"];
		$info=0;
		
		$sqlGetTipoEscuela = "select f_idEscuela('".$escuela."');";
		$resGetTipoEscuela = mysqli_query($conexion,$sqlGetTipoEscuela);
		$info = mysqli_affected_rows($conexion);
		echo $info;
		
	}else{
		header("location:./../index.php");
	}
	
?>