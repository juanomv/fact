<?php
try {
if(ValidaUsuario()==false){echo "<script type=''> alerta('Por favor inicie sesion');	</script>"; return false;}
require_once("funciones.php");
	$password_temp=genera_clave();
	$modulo=$_POST["opcion_contenido"];
	unset($campos);
    $campos[0]="codigo";
    $campos[1]="punto_emision";
    $campos[2]="nombres";
    $campos[3]="empresa";
    $campos[4]="sucursal";
    $campos[5]="correo";
    $campos[6]="rol";
    $campos[7]="cedula";
    $campos[8]="celular";
	if(f_valida_objetos($campos)==false){
		$msg="Aparentemente faltan objetos del sistema:<br>Por favor cierre sision y vuelva a iniciar";
    	echo "<script>alerta('".$msg."');</script>";
		return false;
	}
	$msg_error="";
	if ($_POST["correo"]==''){$msg_error=$msg_error."Ingrese el Correo electronico.<br>";}
	if ($_POST["nombres"]==''){$msg_error=$msg_error."Ingrese los Nombres Completos.<br>";}
	if ($_POST["cedula"]==''){$msg_error=$msg_error."Ingrese la cedula.<br>";}
	if ($_POST["celular"]==''){$msg_error=$msg_error."Ingrese el numero celular.<br>";}
	if ($_POST["rol"]=='-1'){$msg_error=$msg_error."Seleccione el rol.<br>";}
	if ($_POST["empresa"]=='-1'){$msg_error=$msg_error."Seleccione la empresa.<br>";}
	if ($_POST["sucursal"]=='-1'){$msg_error=$msg_error."Seleccione la sucursal.<br>";}
	if ($_POST["punto_emision"]=='-1'){$msg_error=$msg_error."Seleccione el punto de emision.<br>";}
	//if ($_POST["clave"]==''){$msg_error=$msg_error."Ingrese la clave.<br>";}
	
	
	if($msg_error==""){
		unset($campos);
		$campos[0]="codigo=codigo";
		$campos[1]="modulo=".$modulo;
		$campos[2]="usuario=sesion►";
		$campos[3]="clave=".$password_temp;
		$campos[4]="rol=rol";
		$campos[5]="estado=chk";
		$campos[6]="nombres=nombres";
		$campos[7]="cedula=cedula";
		$campos[8]="celular=celular";
		$campos[9]="correo=correo";
		$campos[10]="cuenta=".get_sesion("id_cuenta");
		$campos[11]="empresa=empresa";
		$campos[12]="sucursal=sucursal";
		$campos[13]="punto_emision=punto_emision";
		$sql="select * from ".f_genera_parametros_v("sis.web_reg_usuarios",$campos);
		//echo $sql;
		//return false;
		$res=pg_query($conn,$sql);
		$reg=pg_fetch_array($res);
    	$cerrar_ventana="CerrarForm();";
    	if($reg["res"]=='NUEVO'){$msg="mensaje('Registro Ingresado Correctammente, se envio un correo para que el usuario active la cuenta.!');";
			$asunto="Confirmacion de Registro";
			$nombreDestino=$_POST["nombres"];
			$password_temp=$password_temp."l".$reg["cod"];
			$nuevoCorreo=$_POST["correo"];
			$body="Saludos.<br><p>Se ha realizado un proceso de Registro en el Sistema de Facturación Electrónica FactSis<br><br>
			Valida tu cuenta mediante el sigueinte link: https://factmovil.vrs.com.ec/factmovil/valid/index.php?id=".$password_temp."<br><br>
			Si usted no ha realizado el proceso, No considere este mensaje.</p>";
			$respuestaEmail=enviaMail($asunto,$nuevoCorreo,$nombreDestino,$body);
		}
        if($reg["res"]=='UPDATE'){$msg="mensaje('Registro actualizado Correctammente');";}
    	if($reg["res"]=='ERROR'){$cerrar_ventana="";$msg="alerta('Error : ".$reg["cod"]."');";}                     
        echo "<script>".$cerrar_ventana.$msg." MuestraDatos_contenido();</script>";
	}else{
    	$msg="Para continuar realice lo siguiente:<br>".$msg_error;
    	echo "<script>alerta('".$msg."');</script>";
	}//FIN if($msg_error==""){
} catch (Exception $e) {
    $msg=$e->getMessage();
	echo "<script>alerta('".$msg."');</script>";
}


?>