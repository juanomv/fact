<?php
try {
if(ValidaUsuario()==false){echo "<script type=''> alerta('Por favor inicie sesion');	</script>"; return false;}
require_once("funciones.php");
	$password_temp=genera_clave();
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
	if ($_POST["nombre"]==''){$msg_error=$msg_error."Ingrese el nombre de la caja.<br>";}
	//if ($_POST["siglas"]==''){$msg_error=$msg_error."Ingrese las siglas.<br>";}
	
/*
	pcodigo character varying,
	pmodulo character varying,
	pusuario character varying,
	pcuenta character varying,
	pempresa character varying,
	psucursal character varying,
	pnombre character varying,
	psub_categorias text,
*/
	if($msg_error==""){
		$sub_categorias="";
		$puntocoma="";
		for($i=0;$i<count($_POST["sub_categoria"]);$i++){
			 if($_POST["sub_categoria"][$i]!=''){
			 	$sub_categorias=$sub_categorias.$puntocoma.$_POST["codigo_sub_categoria"][$i]."►".$_POST["sub_categoria"][$i];
			 	$puntocoma="|";
			 }
		}	
		unset($campos);
		$campos[0]="codigo=codigo";
		$campos[count($campos)]="modulo=".$modulo;
		$campos[count($campos)]="usuario=sesion►";
		$campos[count($campos)]="id_cuenta=sesion►";
		$campos[count($campos)]="empresa=sesion►";
		$campos[count($campos)]="sucursal=sesion►";
		$campos[count($campos)]="nombre=nombre";
		$campos[count($campos)]="sub_categorias=".$sub_categorias;

		$sql="select * from ".f_genera_parametros_v("inv.web_reg_categoria",$campos);
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