<?php
    session_start();
    include("./configBD.php");
    if(isset($_SESSION["usuario"])){
		$nombre=$_POST["nombre"];
		$usuario=$_POST["usuario"];
		$contra=$_POST["contra"];
		$contra=md5($contra);
		$tel=$_POST["tel"];
		$sqlEditarStaff = "update staff set nombre='".$nombre
		."', pasword='".$contra."', telefono='".$tel."' where usuario='".$usuario."';";
		$resEditarStaff = mysqli_query($conexion, $sqlEditarStaff);
		$info = mysqli_num_rows($resEditarStaff);
		echo $info;
		
	}else{
		header("location:./../index.php");
	}

?>