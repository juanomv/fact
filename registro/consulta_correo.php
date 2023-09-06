<?php 
require_once("../conexion.php");
$correo=$_POST["txtcorreo"];
if($correo!=""){
	//consultar si ese correo existe en la base de datos
	$buscar  = array("'", " insert ", " delete ", " update ", " select "," into ", " or ","'");
	$reemplazar = array(" ", " ", " ", " ", " "," "," "," ");
	$usuario=f_sin_sql($correo);
	$sql="select count(*) as existe from sis.usuario where correo='".$correo."'";
	$res=pg_query($conn,$sql);
	if ($reg=pg_fetch_array($res)){ 
		if($reg["existe"]==1){
			echo "<script>
			$('#pMensajeCorreo').html('Correo ya se encuentra registrado, intenta con otro o recupera tu clave');
			$('#auto').val('N');
			$('#iconoMsgMail').removeClass('fa-check');
			$('#iconoMsgMail').addClass('fa-ban');
			$('#iconoMsgMail').css('color','red');
			$('#botonRegistrar').attr('disabled', true);
			</script>";
		}
		else{
			echo "<script>
			$('#pMensajeCorreo').html(''); 
			$('#iconoMsgMail').removeClass('fa-ban');
			$('#iconoMsgMail').addClass('fa-check');
			$('#iconoMsgMail').css('color','green');
			$('#auto').val('S');
			$('#botonRegistrar').removeAttr('disabled');
			</script>";	
		}
	}
	if(isset($_SESSION["inicio_registro"])){
		if(($_SESSION["inicio_registro"]% 10)==0){
			$mensajeProceso="Llevas ".$_SESSION["inicio_registro"]." intentos. el sistema se bloqueara con mas de 30 Intentos.";
			echo "<script>$('#msgProceso').html('".$mensajeProceso."');</script>";
		}
		if($_SESSION["inicio_registro"]>30){
			echo "<script>window.location='registro.php'</script>";
			}
		$_SESSION["inicio_registro"]++;
		
	}
}else{echo "<script>$('#pMensajeCorreo').html('Ingrese un correo electronico')</script>";}
?>
