<?php
	include("./enviarCorreo.php");
	$enviar = new EnviarCorreo();
	$enviar->enviar_invitacion('BAEE980918P68','Emanuel','Barrera','Estrella','Premio1','ESCOM','cesar.saulo.u2@gmail.com');
	
?>