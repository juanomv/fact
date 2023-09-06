<?php
try {
if(ValidaUsuario()==false){echo "<script type=''> alerta('Por favor inicie sesion');	</script>"; return false;}
require_once("funciones.php");
	$password_temp=genera_clave();
	$modulo=$_POST["opcion_contenido"];
	unset($campos);
    $campos[0]="codigo";
    $campos[1]="nombre";
    $campos[2]="margen";
	$campos[3]="en_uso";
	if(f_valida_objetos($campos)==false){
		$msg="Aparentemente faltan objetos del sistema:<br>Por favor cierre sision y vuelva a iniciar";
    	echo "<script>alerta('".$msg."');</script>";
		return false;
	}
	$msg_error="";
	if ($_POST["nombre"]==''){$msg_error=$msg_error."Ingrese el nombre de la caja.<br>";}
	if ($_POST["margen"]==''){$msg_error=$msg_error."Ingrese el margen de ganancia.<br>";}

/*
	pcodigo character varying,
	pmodulo character varying,
	pusuario character varying,
	pcuenta character varying,
	pempresa character varying,
	psucursal character varying,
	pnombre character varying,
	pmargen numeric,
*/
	
	if($msg_error==""){
		unset($campos);
		$campos[0]="codigo=codigo";
		$campos[count($campos)]="modulo=".$modulo;
		$campos[count($campos)]="usuario=sesion►";
		$campos[count($campos)]="id_cuenta=sesion►";
		$campos[count($campos)]="empresa=sesion►";
		$campos[count($campos)]="sucursal=sesion►";
		$campos[count($campos)]="nombre=nombre";
		$campos[count($campos)]="margen=margen";
		$campos[count($campos)]="en_uso=en_uso";

		$sql="select * from ".f_genera_parametros_v("fact.web_reg_lista_precio",$campos);
		//echo $sql;
		//return false;
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