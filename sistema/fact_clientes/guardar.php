<?php
try {
if(ValidaUsuario()==false){echo "<script type=''> mensaje('Por favor inicie sesion');	</script>"; return false;}
	$modulo=$_POST["opcion_contenido"];
	unset($campos);
    $campos[0]="codigo";
    $campos[1]="cedula";
    $campos[2]="tipo_persona";
    $campos[3]="nombre";
    $campos[4]="direccion";
    $campos[5]="telefono";
    $campos[6]="tipo_identificacion";
    $campos[7]="email";
	$campos[8]="tipo_contribuyente";
	if(f_valida_objetos($campos)==false){
		$msg="Aparentemente faltan objetos del sistema:<br>Por favor cierre sision y vuelva a iniciar";
    	echo "<script>alerta('".$msg."');</script>";
		return false;
	}
	$msg_error="";
	if ($_POST["cedula"]==''){$msg_error="Ingrese la Identificacion.<br>";}
	//if ($_POST["apellido"]==''){$msg_error=$msg_error."Ingrese El Nombre.<br>";}
	if ($_POST["direccion"]==''){$msg_error=$msg_error."Ingrese La direccion.<br>";}
	if ($_POST["telefono"]==''){$msg_error=$msg_error."Ingrese La Telefono.<br>";}
	if ($_POST["email"]==''){$msg_error=$msg_error."Ingrese La Correo.<br>";}
	if ($_POST["tipo_identificacion"]=='-1'){$msg_error=$msg_error."Seleccione el tipo de identificacion.<br>";}
	if ($_POST["tipo_contribuyente"]=='-1'){$msg_error=$msg_error."Seleccione el tipo de contribuyente.<br>";}
	if ($_POST["tipo_persona"]=='-1'){$msg_error=$msg_error."Seleccione el tipo de persona.<br>";}
/*	
	pcodigo character varying,
	pmodulo character varying,
	pusuario character varying,
	pcuenta character varying,
	pempresa character varying,
	psucursal character varying,
	ptipo_identificacion character varying,
	pcedula character varying,
	pnombre character varying,
	pdireccion character varying,
	pemail character varying,
	ptelefono character varying,
	ptipo character varying,
	ptipo_contribuyente character varying,
	ptipo_persona character varying,
*/	
	if($msg_error==""){
		unset($campos);
		$campos[0]="codigo=codigo";
		$campos[count($campos)]="modulo=".$modulo;
		$campos[count($campos)]="usuario=sesion►";
		$campos[count($campos)]="id_cuenta=sesion►";
		$campos[count($campos)]="empresa=sesion►";
		$campos[count($campos)]="sucursal=sesion►";
		$campos[count($campos)]="tipo_identificacion=tipo_identificacion";
		$campos[count($campos)]="cedula=cedula";
		$campos[count($campos)]="nombre=nombre";
		$campos[count($campos)]="direccion=direccion";
		$campos[count($campos)]="email=email";
		$campos[count($campos)]="telefono=telefono";
		$campos[count($campos)]="tipo=CLI";
		$campos[count($campos)]="tipo_contribuyente=tipo_contribuyente";
		$campos[count($campos)]="tipo_persona=tipo_persona";
		$sql="select * from ".f_genera_parametros_v("fact.web_reg_cliente_proveedor",$campos);
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