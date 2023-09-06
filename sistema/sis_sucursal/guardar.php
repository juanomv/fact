<?php
try {
if(ValidaUsuario()==false){echo "<script type=''> mensaje('Por favor inicie sesion');	</script>"; return false;}

	
	$modulo=$_POST["opcion_contenido"];
	unset($campos);
    $campos[0]="codigo";
    $campos[1]="nombre";
    $campos[2]="direccion";
    $campos[3]="telefono";
    $campos[4]="codigo_fact";
	if(f_valida_objetos($campos)==false){
		$msg="Aparentemente faltan objetos del sistema:<br>Por favor cierre sision y vuelva a iniciar";
    	echo "<script>alerta('".$msg."');</script>";
		return false;
	}
	$msg_error="";
	if ($_POST["nombre"]==''){$msg_error="Ingrese la nombre.<br>";}
	if ($_POST["codigo_fact"]==''){$msg_error="Ingrese Codigo de Facturacion.<br>";}
	if($msg_error==""){
		unset($campos);
		$campos[0]="codigo=codigo";
		$campos[1]="modulo=".$modulo;
    	$campos[2]="usuario=sesion►";
		$campos[3]="id_cuenta=sesion►";
		$campos[4]="empresa=sesion►";
		$campos[5]="nombre=nombre";
		$campos[6]="direccion=direccion";
		$campos[7]="telefono=telefono";
		$campos[8]="codigo_fact=codigo_fact";
		$sql="select * from ".f_genera_parametros_v("sis.web_reg_sucursal",$campos);
		//echo $sql;
		$res=pg_query($conn,$sql);
		$reg=pg_fetch_array($res);
    	$cerrar_ventana="CerrarForm();";
    	if($reg["res"]=='NUEVO'){$msg="mensaje('Registro Ingresado Correctammente');";}
        if($reg["res"]=='UPDATE'){$msg="mensaje('Registro actualizado Correctammente');";}
    	if($reg["res"]=='ERROR'){$cerrar_ventana="";$msg="alerta('Error : ".$reg["cod"]."');"; }                     
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