<?php
    session_start();
    include("./configBD.php");
    if(isset($_SESSION["usuario"])){
		$escuela=$_POST["escuela"];
		
		
		$sqlBorrarEscuela = "call sp_borrarEscuela('".$escuela."');";
		$resBorrarEscuela = mysqli_query($conexion, $sqlBorrarEscuela);
		$info = mysqli_num_rows($resBorrarEscuela);
		echo $info;
		
	}else{
		header("location:./../index.php");
	}

?>