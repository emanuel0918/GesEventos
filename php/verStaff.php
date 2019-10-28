<?php
    session_start();
    include("./configBD.php");

    $usuario =  $_POST["usr"];

    $sqlVerGalardonado = "select * from staff where usuario='".$usuario."';";
    $resVerGalardonado = mysqli_query($conexion,$sqlVerGalardonado);
    $galardonado = mysqli_fetch_assoc($resVerGalardonado);

    echo json_encode($galardonado);
?>