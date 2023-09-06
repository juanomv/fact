<?php
try {
if(ValidaUsuario()==false){echo "<script type=''> mensaje('Por favor inicie sesion');	</script>"; return false;}
	$modulo=$_POST["opcion_contenido"];
	unset($campos);
		$campos[0]="codigo";
		$campos[1]="nombre";
	if(f_valida_objetos($campos)==false){
		$msg="Aparentemente faltan objetos del sistema:<br>Por favor cierre sision y vuelva a iniciar";
    	echo "<script>alerta('".$msg."');</script>";
		return false;
	}
	$msg_error="";
	if ($_POST["nombre"]==''){$msg_error="Ingrese la nombre.<br>";}
	if ($_POST["nivel"]==''){$msg_error=$msg_error."Ingrese el nivel.<br>";}
	if($msg_error==""){
		unset($campos);
		$campos[0]="codigo=codigo";
		$campos[1]="usuario=sesion►";
		$campos[2]="empresa=sesion►";
		$campos[3]="nombre=nombre";
		$campos[4]="nivel=nivel";
		$campos[5]="mostrar=mostrar";
		$sql="select * from ".f_genera_parametros_v("sis.web_reg_rol_usuarios",$campos);
		$res=pg_query($conn,$sql);
		$reg=pg_fetch_array($res);
    	$cerrar_ventana="CerrarForm();";
    	if($reg["res"]=='NUEVO'){$msg="mensaje('Registro Ingresado Correctammente');";}
        if($reg["res"]=='UPDATE'){$msg="mensaje('Registro actualizado Correctammente');";}
    	if($reg["res"]=='ERROR'){$cerrar_ventana="";$msg="alerta('Error : ".$reg["cod"]."');";}                     
        echo "<script>".$cerrar_ventana." ".$msg." MuestraDatos_contenido();</script>";
	}else{
    	$msg="Para continuar realice lo siguiente:<br>".$msg_error;
    	echo "<script>alerta('".$msg."');</script>";
	}//FIN if($msg_error==""){
} catch (Exception $e) {
    $msg=$e->getMessage();
	echo "<script>alerta('".$msg."');</script>";
}


?>