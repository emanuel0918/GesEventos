<?php
	session_start();
	//session_destroy();
	unset($_SESSION["usuario"]);
	header("location:../");
?>