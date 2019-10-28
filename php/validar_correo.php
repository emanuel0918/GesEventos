<?php
    session_start();
	$email = $_POST['correo'];
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo 0;
	}else{
		echo 1;
	}
	
?>