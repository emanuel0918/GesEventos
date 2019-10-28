<?php

class CrearCodigo
{
	#simbolos del token
	#var $caracteres="QWERTYUIOPASDFGHJKLZXCVBNM0123456789";
	#var $caracteres="QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm0123456789";
	var $caracteres="0123456789";
	#longitud del token
	var $long=8;
	
    function __construct(){
		include "QR_BarCode.php";
		
    }
	
	function crearToken(){
		$codigo='G00';
		for ($i = 1; $i <= $this->long; $i++) {
			$random_char=(rand(0,(strlen($this->caracteres)-1)));
			$codigo.=$this->caracteres[$random_char];
		}
		return $codigo;
	}
	
	function almacenarQR($rfc){
		include("./configBD.php");
		$codigo=$this->crearToken();
		$sqlGuardarToken = "call sp_guardarTokenGalardonado('".$rfc."','".$codigo."');";
		mysqli_query($conexion,$sqlGuardarToken);
		
		#QR_BarCode object
		$qr = new QR_BarCode();

		#create text QR code
		$qr->text('192.168.0.9/tweb/php/validarGalardonado.php?tk='.$codigo);

		#almacenar imagen con el codigo QR
		$qr->qrCode(350,'tokens/'.$codigo.'.png');
		return $codigo;
	}
}
?>