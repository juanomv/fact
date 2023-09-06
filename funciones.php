<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

function enviaMail($asunto,$emailDestino,$nombreDestino,$contenido){
	unset($respuesta);
	$respuesta[0]=""; //esatdo de envio "ERROR" O "OK"
	$respuesta[1]=""; // mensaje de envio
	$random_envio=random_int(10000,99999);
	ob_start();
	$cta_email="facturacion@vrs.com.ec";
	$clave="HvSystem.2020";
	$host="smtp.vrs.com.ec";
	$puerto=587;
	$SMTPSecure='tls';
	$mail = new PHPMailer(true);
	
	try {	
	
		$mail->SMTPDebug = 2;                      //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = $host;                     //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = $cta_email;                     //SMTP username
		$mail->Password   = $clave;                               //SMTP password
		$mail->SMTPSecure = $SMTPSecure;            //Enable implicit TLS encryption
		$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		$mail->Subject = $asunto;
		$mail->isHTML(true);
		$mail->setFrom($cta_email, 'VR Soluciones');
		$mail->addAddress($emailDestino, $nombreDestino);
		$mail->SMTPOptions = array(
			'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
			)
		);
		$mail->Body = $contenido;
		if (!$mail->send()) {
				$_SESSION["envio_correo".$random_envio]="ERROR";
				$_SESSION["envio_mensaje".$random_envio]=$mail->ErrorInfo;
		} else {
			$_SESSION["envio_correo".$random_envio]="OK";
			$_SESSION["envio_mensaje".$random_envio]="Mensaje enviado correctamente";
		}
		
		
	} catch (Exception $e) {
			$_SESSION["envio_correo".$random_envio]="ERROR";
			$_SESSION["envio_mensaje".$random_envio]=$e;
	}
	$contenido_envio =ob_get_clean();
	$respuesta[0]=$_SESSION["envio_correo".$random_envio]; //esatdo de envio "ERROR" O "OK"
	$respuesta[1]=$_SESSION["envio_mensaje".$random_envio]; // mensaje de envio
	unset($_SESSION["envio_correo".$random_envio]);
	unset($_SESSION["envio_mensaje".$random_envio]);
	return $respuesta;
}
function genera_clave () {
	$char = "abcdefghijkmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$max = strlen($char) - 1;
	$len =rand(8,12);
	$respuesta = "";
	for ($i=0; $i<=$len; $i++) { $respuesta .= substr($char, rand(0, $max), 1); }
	return $respuesta;
}
?>
