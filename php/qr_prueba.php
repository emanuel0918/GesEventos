<?php
	#include QR_BarCode class
	include "QR_BarCode.php"; 
	
	#simbolos del token SOLO si se distinguen mayusculas de minusculas
	#$caracteres="QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm123456789";
	
	#simbolos del token sin minusculas
	$caracteres="QWERTYUIOPASDFGHJKLZXCVBNM123456789";
	
	#longitud del token
	$long=21;
	
	$codigo='';
	for ($i = 1; $i <= $long; $i++) {
		$random_char=(rand(0,(strlen($caracteres)-1)));
		$codigo.=$caracteres[$random_char];
	}
	#crear directorio del QR con el token
	mkdir($codigo);

	#QR_BarCode object
	$qr = new QR_BarCode();
	
	#url del QR
	$url_servidor='192.168.0.9';
	
	#nombre del proyecto
	$nombre_proyecto='qr_codes';
	
	#nombre del archivo PHP
	$archivo_valida='validate.php';

	#create text QR code
	$qr->text($url_servidor.'/'.$nombre_proyecto.$archivo_valida.'?tk='.$codigo);

	#almacenar imagen con el codigo QR
	$qr->qrCode(350,$codigo.'/'.$codigo.'.png');
?>