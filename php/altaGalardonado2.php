<?php
    session_start();
    include("./configBD.php");
    include("./crearCodigo.php");
    include("./generarPDF.php");
    include("./enviarCorreo.php");
    if(isset($_SESSION["usuario"])){
		$nombre=$_POST["nombre"];
		$RFC=$_POST["rfc"];
		$primerApe=$_POST["primerApe"];
		$segundoApe=$_POST["segundoApe"];
		$correo=$_POST["correo"];
		$tel=$_POST["tel"];
		$observaciones=$_POST["observaciones"];
		$sexo=$_POST["sexo"];
		$discapacidad=$_POST["discapacidad"];
		$recon=$_POST["recon"];
		$escuela=$_POST["escuela"];
		$crearCodigo=new CrearCodigo();
		
		$v_sexo=1;
		if($sexo=='Hombre'){
			$v_sexo=0;
		}
		
		$v_discapacidad=0;
		if($discapacidad=='Si'){
			$v_discapacidad=1;
		}
		
		
		$sqlAltaGalardonado = "call sp_altaGalardonado('".$RFC."','"
		.$nombre."','".$primerApe."','".$segundoApe."',".$v_sexo.",'"
		.$observaciones."','".$correo."','".$escuela."','".$tel."','".$recon."',".$v_discapacidad.");";
		$resAltaGalardonado = mysqli_query($conexion, $sqlAltaGalardonado);
		#Generar Codigo QR
		$token=$crearCodigo->almacenarQR($RFC);
		$sqlGuardarToken = "call sp_guardarTokenGalardonado('".$RFC."','".$token."');";
		mysqli_query($conexion,$sqlGuardarToken);
		
		#Generar Invitacion
		$invitacion = new GenerarPdf();
		$invitacion->generar_invitacion($RFC,$nombre,$primerApe,$segundoApe,$recon,$escuela,$token);

		#Enviar correo
		if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
			$enviar = new EnviarCorreo();
			$enviar->enviar_invitacion($RFC,$nombre,$primerApe,$segundoApe,$recon,$escuela,$correo);
		}
		
		$info = mysqli_affected_rows($conexion);
		echo $info;
		
	}else{
		header("location:./../index.php");
	}
	
?>