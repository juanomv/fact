<?php 
session_start();
require "../capcha/1-captcha.php";
require_once("../conexion.php");
require_once("../funciones.php");
$resultCapcha="";
$mensajeProceso="";

if($PHPCAP->verify($_POST["captcha"])) {
	$resultCapcha = "";
	$nuevoCorreo=$_POST["txtcorreo"];
	//session_unset();
	unset($_SESSION["inicio_registro"]);
	//session_destroy();
	
	$password_temp=genera_clave();
	$asunto="Confirmacion de reseteo de clave";
	$nombreDestino=$_POST["txtnombre"];
	
	unset($campos);
	$campos[0]="correo=".$nuevoCorreo; 
	$campos[1]="calve=".$password_temp;
	$sql="select * from ".f_genera_parametros_v("sis.web_reg_usuario_reset",$campos);
	$res=pg_query($conn,$sql);
	$reg=pg_fetch_array($res);
	if($reg["res"]=='OK'){
		$password_temp=$password_temp."l".$reg["cod"];
		$body="Saludos.<br><p>Desde este correo se ha realizado un proceso de recuperacion de clave en el Sistema de Facturación Electrónica FactSis<br><br>
		Para validar el proceso accede al siguiente link: https://factmovil.vrs.com.ec/factmovil/recuperar/recuperar.php?id=".$password_temp."<br><br>
		Si usted no ha realizado el proceso, No considere este mensaje.<br>
		Recuerde este link tiene una validez de 10 dias.</p>";
		$respuestaEmail=enviaMail($asunto,$nuevoCorreo,$nombreDestino,$body);
		if($respuestaEmail[0]=="OK"){ //Se envio el correo corectamente
			$mensajeProceso="Proceso ejecutado correctamente, Se envió un mensaje de verificación al correo ingresado ".$nuevoCorreo.", con las instrucciones para que ingrese al sistema.";
			ob_start();
			$PHPCAP->prime();
			$PHPCAP->draw();
			$contenido_captcha =ob_get_clean();
			echo '<script>$("#divCaptcha").html("'.$contenido_captcha.'");clear_form();</script>';
		}else{
			$mensajeProceso="Error: ".$respuestaEmail[1];
			$cod_new=$reg["cod"];
			//borramos el usuario que se creo recientemente
			$sql2="Delete from sis.usuario where codigo='".$cod_new."'";
			pg_query($conn,$sql2);
		}
	}else{
		$mensajeProceso="Ocurrio un error2".$reg["cod"];	
	}
	echo "<script>$('#msgProceso').html('".$mensajeProceso."');$('#msgCaptcha').html('".$resultCapcha."');</script>";

}else{
	$resultCapcha="Capcha Incorrecto..! Vuelva a intentarlo.";	
	$mensajeProceso="";
	if(isset($_SESSION["inicio_registro"])){
		if(($_SESSION["inicio_registro"]% 10)==0){
			$mensajeProceso="Llevas ".$_SESSION["inicio_registro"]." intentos. el sistema se bloqueara con mas de 30 Intentos.";
		}
		if($_SESSION["inicio_registro"]>30){
			echo "<script>window.location='registro.php'</script>";
			}
		$_SESSION["inicio_registro"]++;
		
	}
	echo "<script>$('#msgCaptcha').html('".$resultCapcha."');$('#msgProceso').html('".$mensajeProceso."');</script>";
}


?>