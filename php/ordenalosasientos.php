<?php
    session_start();
    include("./ordenarAsientos.php");

	$ordenarAsientos=new OrdenarAsientos();
	$ordenarAsientos->ordenarLosAsientos();
?>