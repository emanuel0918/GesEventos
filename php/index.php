<?php
	session_start();
    if(isset($_SESSION["usuario"])){
		header("location:./listadoGalardonados.php");
	}else{
		header("location:./../index.php");
	}
?>