<?php
    session_start();
    include("./configBD.php");
    $usuario = $_POST["username"];
    $contrasena = $_POST["password"];
    $contrasena = md5($contrasena);

    $sqlCheckUsr = "select f_Login('".$usuario."','".$contrasena."') as 's';";

    $resCheckUsr = mysqli_query($conexion, $sqlCheckUsr);
    $infoCheckUsr = mysqli_fetch_assoc($resCheckUsr);

    if($infoCheckUsr["s"] == 1){
        $_SESSION["usuario"] = $usuario;
    }
	echo $infoCheckUsr["s"];
	
?>