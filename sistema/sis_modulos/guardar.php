<?php
try {
if(ValidaUsuario()==false){echo "<script type=''> mensaje('Por favor inicie sesion');	</script>"; return false;}

	
	$modulo=$_POST["opcion_contenido"];
	unset($campos);
    $campos[0]="codigo";
    $campos[1]="nombre";
    $campos[2]="pagina";
    $campos[3]="tipo";
    $campos[4]="padre";
    $campos[5]="referencia";
    $campos[6]="dir_img";
    $campos[7]="orden";
	if(f_valida_objetos($campos)==false){
		$msg="Aparentemente faltan objetos del sistema:<br>Por favor cierre sision y vuelva a iniciar";
    	echo "<script>alerta('".$msg."');</script>";
		return false;
	}
	$msg_error="";
	if ($_POST["nombre"]==''){$msg_error="Ingrese la nombre.<br>";}
	if ($_POST["orden"]==''){$msg_error=$msg_error."Ingrese orden.<br>";}
	if($msg_error==""){
	
		
		
		unset($campos);
		$campos[0]="codigo=codigo";
		$campos[count($campos)]="modulo=".$modulo;
    	$campos[count($campos)]="usuario=sesion►";
		$campos[count($campos)]="nombre=nombre";
		$campos[count($campos)]="pagina=pagina";
		$campos[count($campos)]="tipo=tipo";
		$campos[count($campos)]="padre=padre";
		$campos[count($campos)]="referencia=referencia";
		$campos[count($campos)]="directo=directo";
		$campos[count($campos)]="dir_img=dir_img";
		$campos[count($campos)]="orden=orden";
		$campos[count($campos)]="varios=varios";
		$campos[count($campos)]="varios_menu=varios_menu";
		$campos[count($campos)]="varios_texto=varios_texto";
		$campos[count($campos)]="varios_color=varios_color";
		$campos[count($campos)]="varios_logo=varios_logo";
		$campos[count($campos)]="varios_padre=varios_padre";
		$campos[count($campos)]="varios_fila=varios_fila";
		
		$sql="select * from ".f_genera_parametros_v("sis.web_reg_modulos",$campos);
		//echo $sql;
		$res=pg_query($conn,$sql);
		$reg=pg_fetch_array($res);
    	$cerrar_ventana="CerrarForm();";
    	if($reg["res"]=='NUEVO'){$msg="mensjae('Registro Ingresado Correctammente');";}
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