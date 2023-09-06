<?php
try {
if(ValidaUsuario()==false){echo "<script type=''> alerta('Por favor inicie sesion');	</script>"; return false;}
require_once("funciones.php");
	$password_temp=genera_clave();
	$modulo=$_POST["opcion_contenido"];
	unset($campos);
    $campos[0]="codigo";
    $campos[1]="aplica_irbpnr";
    $campos[2]="codigo_barra";
    $campos[3]="nombre";
    $campos[4]="descripcion";
    $campos[5]="precio";
    $campos[6]="tipo";
    $campos[7]="unidad";
	$campos[8]="aplica_iva";
	$campos[9]="aplica_ice";
	
	if(f_valida_objetos($campos)==false){
		$msg="Aparentemente faltan objetos del sistema:<br>Por favor cierre sision y vuelva a iniciar";
    	echo "<script>alerta('".$msg."');</script>";
		return false;
	}
	$msg_error="";
	if ($_POST["nombre"]==''){$msg_error=$msg_error."Ingrese el nombre de la caja.<br>";}
	if ($_POST["codigo_barra"]==''){$msg_error=$msg_error."Ingrese el codigo de barra.<br>";}
	if ($_POST["precio"]==''){$msg_error=$msg_error."Ingrese el costo del producto.<br>";}
	if ($_POST["tipo"]==''){$msg_error=$msg_error."Ingrese el secuencial de notas de credito.<br>";}
	if ($_POST["num_partes"]==''){$msg_error=$msg_error."Ingrese el numero de partes.<br>";}
	$borrado="N";
	if(!isset($_POST["borrado"])){$borrado="S";}
	$lista_precio="";
	$barra="";
	for($i=0;$i<count($_POST["lista_codigo"]);$i++){
		if(isset($_POST["lista_precio"][$i])){
			$lista_precio=$lista_precio.$barra.$_POST["lista_codigo"][$i]."►".$_POST["lista_precio"][$i];
			$barra="▲";
		}
	} //FIN for($i=0;$i<count($_POST["prod_detalle"]);$i++){


	if($msg_error==""){
		unset($campos);
		$campos[0]="codigo=codigo";
		$campos[count($campos)]="modulo=".$modulo;
		$campos[count($campos)]="usuario=sesion►";
		$campos[count($campos)]="empresa=sesion►";
		$campos[count($campos)]="id_cuenta=sesion►";
		$campos[count($campos)]="sucursal=sesion►";
		$campos[count($campos)]="periodo=sesion►";
		$campos[count($campos)]="borrado=".$borrado;
		$campos[count($campos)]="codigo_barra=codigo_barra";
		$campos[count($campos)]="nombre=nombre";
		$campos[count($campos)]="descripcion=descripcion";
		$campos[count($campos)]="kardex=kardex";
		$campos[count($campos)]="precio=precio";
		$campos[count($campos)]="lista_precio=".$lista_precio;
		$campos[count($campos)]="valida_stock=valida_stock";
		$campos[count($campos)]="categoria=categoria";
		$campos[count($campos)]="sub_categoria=sub_categoria";
		$campos[count($campos)]="unidad=unidad";
		$campos[count($campos)]="aplica_iva=aplica_iva";
		$campos[count($campos)]="tipo=tipo";
		$campos[count($campos)]="marca=marca";
		$campos[count($campos)]="modelo=modelo";
		$campos[count($campos)]="aplica_ice=aplica_ice";
		$campos[count($campos)]="aplica_irbpnr=aplica_irbpnr";
		$campos[count($campos)]="componente=componente";
		$campos[count($campos)]="producto_padre=producto_padre";
		$campos[count($campos)]="num_partes=num_partes";
		$sql="select * from ".f_genera_parametros_v("inv.web_reg_producto",$campos);
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