<?php
try {
if(ValidaUsuario()==false){echo "<script type=''> mensaje('Por favor inicie sesion');	</script>"; return false;}

	
	$modulo=$_POST["opcion_contenido"];
	unset($campos);
    $campos[0]="codigo";
    $campos[1]="ruc";
    $campos[2]="nombre";
    $campos[3]="direccion";
    $campos[4]="nombre_comercial";
    $campos[5]="obligado_contabilidad";
    $campos[6]="contribuyente_regimen_micro";
    $campos[7]="correo_fact";
	$campos[8]="telefono";
	if(f_valida_objetos($campos)==false){
		$msg="Aparentemente faltan objetos del sistema:<br>Por favor cierre sision y vuelva a iniciar";
    	echo "<script>alerta('".$msg."');</script>";
		return false;
	}
	$msg_error="";
	if ($_POST["ruc"]==''){$msg_error="Ingrese la nombre.<br>";}
	if ($_POST["nombre"]==''){$msg_error=$msg_error."Ingrese Nombre .<br>";}
	if ($_POST["nombre_comercial"]==''){$msg_error=$msg_error."Ingrese Nombre Comercial.<br>";}
	if ($_POST["obligado_contabilidad"]=='-1'){$msg_error=$msg_error."Seleccion si es obligado a llevar contabildiad.<br>";}
	if ($_POST["contribuyente_regimen_micro"]=='-1'){$msg_error=$msg_error."Seleccion regimen micro empresa.<br>";}
	if($msg_error==""){
		unset($campos);
		$campos[0]="codigo=codigo";
		$campos[1]="modulo=".$modulo;
    	$campos[2]="usuario=sesion►";
		$campos[3]="id_cuenta=sesion►";
		$campos[4]="ruc=ruc";
		$campos[5]="nombre=nombre";
		$campos[6]="direccion=direccion";
		$campos[7]="telefono=telefono";
		$campos[8]="nombre_comercial=nombre_comercial";
		$campos[9]="obligado_contabilidad=obligado_contabilidad";
		$campos[10]="contribuyente_regimen_micro=contribuyente_regimen_micro";
		$campos[11]="correo_fact=correo_fact";
		$sql="select * from ".f_genera_parametros_v("sis.web_reg_empresa",$campos);
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