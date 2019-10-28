<?php
    session_start();
    include("./configBD.php");
    if(isset($_SESSION["usuario"])){
		$RFC=$_POST["rfc"];
		
		
		$sqlBorrarGalardonado = "call sp_borrarGalardonado('".$RFC."');";
		$resBorrarGalardonado = mysqli_query($conexion, $sqlBorrarGalardonado);
		$info = mysqli_num_rows($resBorrarGalardonado);
		echo $info;
		
	}else{
		header("location:./../index.php");
	}

?>