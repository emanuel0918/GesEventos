<?php
    session_start();
    include("./configBD.php");

    $rfc =  $_POST["rfc"];

    $sqlVerGalardonado = "select * from vw_Galardonado where rfc='".$rfc."';";
    $resVerGalardonado = mysqli_query($conexion,$sqlVerGalardonado);
    $galardonado = mysqli_fetch_assoc($resVerGalardonado);

    echo json_encode($galardonado);
?>