<?php
    session_start();
    include("./configBD.php");
    if(isset($_SESSION["usuario"])){
		$tabla = $_POST['tabla'];
		$row = $_POST['row'];
		$valor = $_POST['valor'];
		
		$infoCheckVal=0;

		$sqlCheckVal = "SELECT * FROM  $tabla WHERE $row='$valor';";
		$resCheckVal = mysqli_query($conexion, $sqlCheckVal);
		$infoCheckVal = mysqli_num_rows($resCheckVal);
		echo $infoCheckVal;
		
	}else{
		header("location:./../index.php");
	}
	
?>