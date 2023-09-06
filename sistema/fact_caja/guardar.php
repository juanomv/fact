<?php
try {
if(ValidaUsuario()==false){echo "<script type=''> alerta('Por favor inicie sesion');	</script>"; return false;}
require_once("funciones.php");
	$password_temp=genera_clave();
	$modulo=$_POST["opcion_contenido"];
	unset($campos);
    $campos[0]="codigo";
    $campos[1]="nombre";
    $campos[2]="punto_emision";
    $campos[3]="seq_factura";
    $campos[4]="seq_nota_cred";
    $campos[5]="seq_nota_deb";
    $campos[6]="seq_guia";
    $campos[7]="seq_rete";
	if(f_valida_objetos($campos)==false){
		$msg="Aparentemente faltan objetos del sistema:<br>Por favor cierre sision y vuelva a iniciar";
    	echo "<script>alerta('".$msg."');</script>";
		return false;
	}
	$msg_error="";
	if ($_POST["nombre"]==''){$msg_error=$msg_error."Ingrese el nombre de la caja.<br>";}
	if ($_POST["punto_emision"]==''){$msg_error=$msg_error."Ingrese el punto de emision de la caja.<br>";}
	if ($_POST["seq_factura"]==''){$msg_error=$msg_error."Ingrese el secuencial de facturas.<br>";}
	if ($_POST["seq_nota_cred"]==''){$msg_error=$msg_error."Ingrese el secuencial de notas de credito.<br>";}
	if ($_POST["seq_nota_deb"]==''){$msg_error=$msg_error."Ingrese el secuencial de notas de debito.<br>";}
	if ($_POST["seq_guia"]=='-1'){$msg_error=$msg_error."Ingrese el secuencial de guias.<br>";}
	if ($_POST["seq_rete"]=='-1'){$msg_error=$msg_error."Ingrese el secuencial de retenciones.<br>";}

/*
	pcodigo character varying,
	pmodulo character varying,
	pusuario character varying,
	pempresa character varying,
	pcuenta character varying,
	psucursal character varying,
	pnombre character varying,
	ppunto_emision character varying,
	psec_inicial character varying,
	psec_inicial_ret character varying,
	psec_inicial_gui character varying,
	psec_inicial_nc character varying,
	psec_inicial_nd character varying,
*/
	
	if($msg_error==""){
		unset($campos);
		$campos[0]="codigo=codigo";
		$campos[count($campos)]="modulo=".$modulo;
		$campos[count($campos)]="usuario=sesion►";
		$campos[count($campos)]="empresa=sesion►";
		$campos[count($campos)]="id_cuenta=sesion►";
		$campos[count($campos)]="sucursal=sesion►";
		$campos[count($campos)]="nombre=nombre";
		$campos[count($campos)]="punto_emision=punto_emision";
		$campos[count($campos)]="seq_factura=seq_factura";
		$campos[count($campos)]="seq_rete=seq_rete";
		$campos[count($campos)]="seq_guia=seq_guia";
		$campos[count($campos)]="seq_nota_cred=seq_nota_cred";
		$campos[count($campos)]="seq_nota_deb=seq_nota_deb";

		$sql="select * from ".f_genera_parametros_v("fact.web_reg_caja",$campos);
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