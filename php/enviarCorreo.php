<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 * This uses traditional id & password authentication - look at the gmail_xoauth.phps
 * example to see how to use XOAUTH2.
 * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
 */
use PHPMailer\PHPMailer\PHPMailer;
class EnviarCorreo
{
    function __construct(){
		//Import PHPMailer classes into the global namespace
		require 'vendor/autoload.php';
	}
	
	function enviar_invitacion($rfc,$nombre,$primerApe,$segundoApe,$recon,$escuela,$correo){
		$s1=strtolower($recon);
		$s2="diplomas";
		$s3="diploma";
		$s4="presea";
		$s5="reconocimiento";
		$s5="premio";
		$e1=strtolower($escuela);
		$e2="cecyt";
		$mensaje='';
		if (strpos($s1,$s2)!==false) {
			if (strpos($e1,$e2)!==false) {
				$mensaje='Por medio de la presente le hacemos de saber a usted '
						.'<label class="negrita">'.$nombre.' '.$primerApe.' '.$segundoApe
						.'</label> conocer que usted ser&aacute; galardonado ganador de uno de los '
						.$recon.' como m&eacute;rito polit&eacute;cnico por sus servicios al '
						.$escuela.' de nuestra prestigiosa instituci&oacute;n.';
			}else {
				$mensaje='Por medio de la presente le hacemos de saber a usted '
						.'<label class="negrita">'.$nombre.' '.$primerApe.' '.$segundoApe
						.'</label> conocer que usted ser&aacute; galardonado ganador de uno de los '
						.$recon.' como m&eacute;rito polit&eacute;cnico por sus servicios a la '
						.$escuela.' de nuestra prestigiosa instituci&oacute;n.';
			}
		}else if (strpos($s1,$s3)!==false) {
			if (strpos($e1,$e2)!==false) {
				$mensaje='Por medio de la presente le hacemos de saber a usted '
						.'<label class="negrita">'.$nombre.' '.$primerApe.' '.$segundoApe
						.'</label> conocer que usted ser&aacute; galardonado ganador del '
						.$recon.' como m&eacute;rito polit&eacute;cnico por sus servicios al '
						.$escuela.' de nuestra prestigiosa instituci&oacute;n.';
			}else {
				$mensaje='Por medio de la presente le hacemos de saber a usted '
						.'<label class="negrita">'.$nombre.' '.$primerApe.' '.$segundoApe
						.'</label> conocer que usted ser&aacute; galardonado ganador del '
						.$recon.' como m&eacute;rito polit&eacute;cnico por sus servicios a la '
						.$escuela.' de nuestra prestigiosa instituci&oacute;n.';
			}
		}else if (strpos($s1,$s4)!==false) {
			if (strpos($e1,$e2)!==false) {
				$mensaje='Por medio de la presente le hacemos de saber a usted '
						.'<label class="negrita">'.$nombre.' '.$primerApe.' '.$segundoApe
						.'</label> conocer que usted ser&aacute; galardonado ganador de la '
						.$recon.' como m&eacute;rito polit&eacute;cnico por sus servicios al '
						.$escuela.' de nuestra prestigiosa instituci&oacute;n.';
			}else {
				$mensaje='Por medio de la presente le hacemos de saber a usted '
						.'<label class="negrita">'.$nombre.' '.$primerApe.' '.$segundoApe
						.'</label> conocer que usted ser&aacute; galardonado ganador de uno de la '
						.$recon.' como m&eacute;rito polit&eacute;cnico por sus servicios a la '
						.$escuela.' de nuestra prestigiosa instituci&oacute;n.';
			}
		}else  {
			if (strpos($e1,$e2)!==false) {
				$mensaje='Por medio de la presente le hacemos de saber a usted '
						.'<label class="negrita">'.$nombre.' '.$primerApe.' '.$segundoApe
						.'</label> conocer que usted ser&aacute; galardonado ganador del '
						.$recon.' como m&eacute;rito polit&eacute;cnico por sus servicios al '
						.$escuela.' de nuestra prestigiosa instituci&oacute;n.';
			}else{
				$mensaje='Por medio de la presente le hacemos de saber a usted '
						.'<label class="negrita">'.$nombre.' '.$primerApe.' '.$segundoApe
						.'</label> conocer que usted ser&aacute; galardonado ganador de uno del '
						.$recon.' como m&eacute;rito polit&eacute;cnico por sus servicios a la '
						.$escuela.' de nuestra prestigiosa instituci&oacute;n.';
			}
		}
		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 2;
		//Set the hostname of the mail server
		$mail->Host = 'smtp.gmail.com';
		// use
		// $mail->Host = gethostbyname('smtp.gmail.com');
		// if your network does not support SMTP over IPv6
		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = 587;
		//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = 'tls';
		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;
		//Username to use for SMTP authentication - use full email address for gmail
		$mail->Username = "heatmap.quanthink@gmail.com";
		//Password to use for SMTP authentication
		$mail->Password = "mot_de_passe";
		//Set who the message is to be sent from
		$mail->setFrom('heatmap.quanthink@gmail.com', 'Ceremonia de Premiacion');
		//Set an alternative reply-to address
		$mail->addReplyTo('heatmap.quanthink@gmail.com', 'Gestion Empresarial Quanthink');
		//Set who the message is to be sent to
		$mail->addAddress($correo, 'JackCloudman');
		//Set the subject line
		$mail->Subject = 'Invitacion para la ceremonia de premiacion';
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML('<html><head></head><body>'
		.'<p style="text-align:justify;font-family: Arial;">'.$mensaje.'</p></body></html>');
		//Replace the plain text body with one created manually
		$mail->AltBody = 'This is a plain-text message body';
		//Attach an image file
		$mail->addAttachment('invitaciones/'.$rfc.'.pdf');
		//send the message, check for errors
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!";
			//Section 2: IMAP
			//Uncomment these to save your message in the 'Sent Mail' folder.
			#if (save_mail($mail)) {
			#    echo "Message saved!";
			#}
		}
	}

	//Section 2: IMAP
	//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
	//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
	//You can use imap_getmailboxes($imapStream, '/imap/ssl') to get a list of available folders or labels, this can
	//be useful if you are trying to get this working on a non-Gmail IMAP server.
	function save_mail($mail)
	{
		//You can change 'Sent Mail' to any other folder or tag
		$path = "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail";
		//Tell your server to open an IMAP connection using the same username and password as you used for SMTP
		$imapStream = imap_open($path, $mail->Username, $mail->Password);
		$result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
		imap_close($imapStream);
		return $result;
	}

}
?>