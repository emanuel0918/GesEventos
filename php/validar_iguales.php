<?php
    session_start();
	$contra1 = $_POST['contra1'];
	$contra2 = $_POST['contra2'];
	if($contra1==$contra2){
		echo 1;
	}else{
		echo 0;
	}	
	
?>