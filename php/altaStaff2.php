<?php
    session_start();
    include("./configBD.php");
    include("./enviarCorreoStaff.php");
    if(isset($_SESSION["usuario"])){
		$nombre=$_POST["nombre"];
		$usuario=$_POST["usuario"];
		$contra=$_POST["contra"];
		$contraNoCifrada=$contra;
		$contra=md5($contra);
		$privilegio=$_POST["privilegio"];
		$correo=$_POST["correo"];
		$tel=$_POST["tel"];
		$tipoUsuario='Usuario Est&aacute;ndar';
		$v_priv=1;
		if($privilegio=='Admin'){
			$v_priv=0;
			$tipoUsuario='Admin';
		}
		
		
		#Enviar correo
		if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
			$enviar = new EnviarCorreoStaff();
			$enviar->enviarMensaje($nombre,$usuario,$contraNoCifrada,$correo,$tipoUsuario);
		}
		
		$sqlAltaStaff = "call sp_altaStaff('".$usuario."','"
		.$contra."','".$nombre."',".$v_priv.",'".$correo."','".$tel."');";
		echo $sqlAltaStaff;
		$resAltaStaff = mysqli_query($conexion, $sqlAltaStaff);
		$info =  mysqli_affected_rows($conexion);
		echo $info;
		
	}else{
		header("location:./../index.php");
	}
	
?>