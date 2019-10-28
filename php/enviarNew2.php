<?php
    session_start();
    include("./configBD.php");
    include("./enviarNew3.php");
    if(isset($_SESSION["usuario"])){
		$titulo=$_POST["titulo"];
		$mensaje=$_POST["mensaje"];
		$enviar=new EnviarNew();
		$enviar->enviarNew($titulo,$mensaje);
		echo 1;
	}else{
		header("location:./../index.php");
	}
	
?>