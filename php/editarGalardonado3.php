<?php
    session_start();
    include("./configBD.php");
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
		
		$v_sexo=1;
		if($sexo=='Hombre'){
			$v_sexo=0;
		}
		
		$v_discapacidad=0;
		if($discapacidad=='Si'){
			$v_discapacidad=1;
		}
		
		
		$sqlAltaGalardonado = "call sp_editarGalardonado('".$RFC."','"
		.$nombre."','".$primerApe."','".$segundoApe."',".$v_sexo.",'"
		.$correo."','".$tel."','".$observaciones."',".$v_discapacidad.",'".$escuela."','".$recon."');";
		$resAltaGalardonado = mysqli_query($conexion, $sqlAltaGalardonado);
		
		$info = mysqli_num_rows($resAltaGalardonado);
		echo $info;
		
	}else{
		header("location:./../index.php");
	}

?>