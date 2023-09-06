<?php
try {
if(ValidaUsuario()==false){echo "<script type=''> mensaje('Por favor inicie sesion');	</script>"; return false;}
	$modulo=$_POST["opcion_contenido"];
	unset($campos);
    $campos[0]="codigo";
    $campos[1]="secuencial";
		$campos[2]="bodega";
		$campos[3]="guia_remision";
		$campos[4]="total_desto";
		$campos[5]="sub_toal_iva12";
		$campos[6]="sub_toal_iva0";
		$campos[7]="sub_toal_noiva";
		$campos[8]="sub_toal_exiva";
	

	if(f_valida_objetos($campos)==false){
		$msg="Aparentemente faltan objetos del sistema:<br>Por favor cierre sision y vuelva a iniciar";
    	echo "<script>mensaje('".$msg."');</script>";
		return false;
	}
	//hay que validar que la fecha se valida
	$msg_error="";
	if ($_POST["caja"]=='-1'){$msg_error="Seleccione la mesa.<br>";}
	if ($_POST["bodega"]=='-1'){$msg_error="Seleccione la bodega.<br>";}
	if ($_POST["fecha"]==''){$msg_error="Ingrese la fecha.<br>";}
	//if ($_POST["nombre_razon_social"]==''){$msg_error="Nombre de cliente incorrecto.<br>";}
	//if ($_POST["cedula_ruc"]==''){$msg_error="Cedula o ruc incorrecto.<br>";}
	if($msg_error==""){
		//obtenemos todas item que se encuentran en el detalle de la factura
		$datos_detalle="";
		$barra="";
		$tipo_operacion="PROF";
		for($i=0;$i<count($_POST["prod_detalle"]);$i++){
			if(isset($_POST["indice_detalle"][$i]) && isset($_POST["cant_detalle"][$i]) && isset($_POST["precio_detalle"][$i]) 
				&& isset($_POST["total_detalle"][$i])){
			 	if($_POST["prod_detalle"][$i]!=''){
					$datos_detalle=$datos_detalle.$barra.$_POST["prod_detalle"][$i].";";
					$datos_detalle=$datos_detalle.$_POST["indice_detalle"][$i].";";
					$datos_detalle=$datos_detalle.$_POST["por_desto_detalle"][$i].";";//porcentaje de descuento no aplica para esta operacion
					$datos_detalle=$datos_detalle.$_POST["desto_detalle"][$i].";";//valor de descuento no aplica para esta operacion
					$datos_detalle=$datos_detalle.$_POST["cant_detalle"][$i].";";
					$datos_detalle=$datos_detalle.$_POST["precio_detalle"][$i].";";
					$datos_detalle=$datos_detalle.$_POST["por_iva"][$i].";";//porcentaje de iva no aplica para esta operacion
					$datos_detalle=$datos_detalle.$_POST["val_iva"][$i].";";//valor de iva no aplica para esta operacion
					$datos_detalle=$datos_detalle.$_POST["total_detalle"][$i].";";
					$datos_detalle=$datos_detalle.$_POST["bodega"].";";
					$datos_detalle=$datos_detalle.$_POST["desc_detalle"][$i].";";// campo que puede ser usado
					$datos_detalle=$datos_detalle.$_POST["aplica_iva"][$i];
					$barra="|";
				 }
			}
			else{
				$msg="Aparentemente faltan objetos del sistema denntro del detalle:<br>Por favor cierre sision y vuelva a iniciar";
    			echo "<script>mensaje('".$msg."');</script>";
				return false; 
			}
		}				
		///////////////////////////////////recopilamos datos de los pagos//////////////
		$datos_pagos="";
		$barra="";
		$suma_pagos=0;
		$total_factura=$_POST["val_total_fact"];
		$msg_error="";
		if($msg_error!=""){
    		echo "<script>mensaje('".$msg_error."');</script>";
			return false;
		}
		//ahora generamos el vector con los datos para el sql;
		unset($campos);
		$campos[0]="codigo=codigo";
		$campos[1]="modulo=".$modulo;
    $campos[2]="usuario=secion";
		$campos[3]="empresa=secion";
		$campos[4]="periodo=secion";
		$campos[5]="sucursal=secion";
		$campos[6]="tipo=".$tipo_operacion;
		$campos[7]="secuencial=secuencial";
		$campos[8]="fecha=fecha";
		$campos[9]="responsable=".get_sesion("persona");
		$campos[10]="cliente_proveedor=";
		$campos[11]="referencia=";
		$campos[12]="punto_emision=punto_emision";
		$campos[13]="guia_remision=guia_remision";
		$campos[14]="total_desto=total_desto";
		$campos[15]="sub_toal_iva12=sub_toal_iva12";
		$campos[16]="sub_toal_iva0=sub_toal_iva0";
		$campos[17]="sub_toal_noiva=sub_toal_noiva";
		$campos[18]="sub_toal_exiva=sub_toal_exiva";
		$campos[19]="sub_toal_fact=sub_toal_fact";
		$campos[20]="val_imp_iva=val_imp_iva";
		$campos[21]="val_imp_ice=val_imp_ice";
		$campos[22]="imp_irbpnr=imp_irbpnr";
		$campos[23]="propina=0";
		$campos[24]="val_total_fact=val_total_fact";
		$campos[25]="cedula_ruc=";
		$campos[26]="nombre_razon_social=";
		$campos[27]="correo_cli=";
		$campos[28]="sesion_caja=PROF";
		$campos[29]="telefono_cli=";
		$campos[30]="direccion_cli=";
		$campos[31]="bodega=bodega";
		$campos[32]="observacion=";
		$campos[33]="caja=caja";
		$campos[34]="lista_precio=lista_precio";
		$campos[35]="por_iva_fact=por_iva_fact";
		$campos[36]="por_desto=por_desto";
		$campos[37]="opcion1=";
		$campos[38]="opcion2=";
		$campos[39]="opcion3=";
		$campos[40]="sub_categorias=".$datos_detalle;
		$sql="select * from ".f_genera_parametros_v("inv.reg_operacion",$campos);
		//echo $sql;
		if(!$result = pg_query ($conn, "begin;")){
			$msg="Error: transaccion no iniciada";
			echo "<script>mensaje('".$msg."');</script>";
			$result = pg_query ($conn, "ROLLBACK;"); 
			return true; 
		}
		if(!$res=pg_query($conn,$sql)){
			$msg="Error: transaccion no finalizada";
			echo "<script>mensaje('".$msg."');</script>";
			$result = pg_query ($conn, "ROLLBACK;"); 
			return true;
		}
		//$res=pg_query($conn,$sql);
		$reg=pg_fetch_array($res);
    $cerrar_ventana="";
		$cod_operacion=$reg["cod"];
    if($reg["res"]=='NUEVO'){$msg="Registro Ingresado Correctammente";$cerrar_ventana="editar('".$cod_operacion."');";}
    if($reg["res"]=='UPDATE'){$msg="Registro actualizado Correctammente";$cerrar_ventana="editar('".$cod_operacion."');";}
		//procesamos el pago de la factura
		if($reg["res"]=='UPDATE' or $reg["res"]=='NUEVO'){
			//alamcenamos los pagos
			}
    if($reg["res"]=='ERROR'){$cerrar_ventana="";$msg="Error : ".$reg["cod"];$result = pg_query ($conn, "ROLLBACK;");} 
		else{
			if(!$res=pg_query($conn,"commit;")){$msg="Error: transaccion no finalizada"; $result = pg_query ($conn, "ROLLBACK; ");}	
		}                    
        echo "<script>".$cerrar_ventana." mensaje('".$msg."'); MuestraDatos_contenido();</script>";
	}else{
    	$msg="Para continuar realice lo siguiente:<br>".$msg_error;
    	echo "<script>mensaje('".$msg."');</script>";
	}//FIN if($msg_error==""){
} catch (Exception $e) {
    $msg=$e->getMessage();
	echo "<script>mensaje('".$msg."');</script>";
}


?>