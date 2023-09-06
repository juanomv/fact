<?php 
$opcion_win=$_POST["opcion_contenido"];
$evento=$_POST["evento_contenido"];
$item=$_POST["item_contenido"];
$sesion_caja=get_sesion("sesion_caja");
$nd=get_sesion("_ND_");
// ahora cargamos datos del pedido caso contario es nuevo
if($evento=='EDIT'){
	$codigo=$item;
	$sql="select 
	op.codigo,
	op.secuencial,
	op.responsable,
	coalesce((select apellido || ' ' || nombre from sis.persona where codigo=op.responsable and grupo='".get_sesion("grupo")."'),'')as nombre_persona,
	op.bodega,
	op.fecha,
	op.fecha_sistema,
	op.observacion,
	op.lista_precio,
	op.punto_emision,
	coalesce((SELECT apellido || ' ' || nombre FROM fact.cliente_proveedor where empresa=op.empresa and codigo=op.cliente_proveedor),'CONSUMIDOR FINAL') as nombre_razon_social,
	coalesce((SELECT cedula FROM fact.cliente_proveedor where empresa=op.empresa and codigo=op.cliente_proveedor),'0000000000') as cedula_ruc,
	coalesce((SELECT telefono FROM fact.cliente_proveedor where empresa=op.empresa and codigo=op.cliente_proveedor),'No registra') as telefono,
	coalesce((SELECT direccion FROM fact.cliente_proveedor where empresa=op.empresa and codigo=op.cliente_proveedor),'No registra') as direccion,
	coalesce((SELECT email FROM fact.cliente_proveedor where empresa=op.empresa and codigo=op.cliente_proveedor),'') as correo_electronico,
	op.cliente_proveedor,
	op.guia_remision,
	trunc(op.sub_total12,".$nd.") as sub_total12,
	trunc(op.sub_total0,".$nd.") as sub_total0,
	trunc(op.sub_total_noiva,".$nd.") as sub_total_noiva,
	trunc(op.sub_total_exentos,".$nd.") as sub_total_exentos,
	trunc(op.sub_total,".$nd.") as sub_total,
	op.por_desto,
	op.tipo,
	op.caja,
	op.estado,
	trunc(op.total_desto,".$nd.") as total_desto,
	trunc(op.val_iva,".$nd.") as val_iva,
	trunc(op.val_ice,".$nd.") as val_ice,
	trunc(op.val_irbpnr,".$nd.") as val_irbpnr,
	trunc(valor_total,".$nd.") as valor_total
	from inv.operacion op where op.ambiente='".get_sesion("ambiente")."' and op.empresa='".get_sesion("empresa")."' and op.periodo='".get_sesion("periodo")."' 
	and op.sucursal='".get_sesion("sucursal")."' and op.codigo='".$codigo."' ;";
	//echo $sql;
	$res=pg_query($conn,$sql);
	//if(pg_num_rows($res)!=0){ 
	if($reg=pg_fetch_array($res)){
		//$res=mysql_query($sql, $Conn);
		//if($fila = mysql_fetch_array($res, MYSQL_ASSOC)){
				$codigo=$reg["codigo"];
				$codigo_temp=$codigo;
				$secuencial=$reg["secuencial"];
				$secuencial_temp=$secuencial;
				$tipo=$reg["tipo"];
				$responsable=$reg["responsable"];
				$bodega=$reg["bodega"];
				$fecha=$reg["fecha"];
				$fecha_sistema=$reg["fecha_sistema"];
				$punto_emision=$reg["punto_emision"];
				$observacion=$reg["observacion"];
				$lista_precio=$reg["lista_precio"];
				$cliente_proveedor=$reg["cliente_proveedor"];
				$nombre_razon_social=utf8_decode($reg["nombre_razon_social"]);
				$cedula_ruc=$reg["cedula_ruc"];
				$telefono_cli=$reg["telefono"];
				$direccion_cli=utf8_decode($reg["direccion"]);
				$correo_cli=$reg["correo_electronico"];
				$guia_remision=$reg["guia_remision"]; //para este modulo este sera estado de la profoema  ABIERTO O CERRADO
				$caja=$reg["caja"]; //para este modulo la caja almacenara la mesa
				$proceso_new="asigna_calculos_objs();"; 
				$sub_total12=$reg["sub_total12"];
				$sub_total0=$reg["sub_total0"];
				$sub_total_noiva=$reg["sub_total_noiva"];
				$sub_total_exentos=$reg["sub_total_exentos"];
				$sub_total=$reg["sub_total"];
				$por_desto=$reg["por_desto"];
				$total_desto=$reg["total_desto"];
				$val_iva=$reg["val_iva"];
				$val_ice=$reg["val_ice"];
				$val_irbpnr=$reg["val_irbpnr"];
				$valor_total=$reg["valor_total"];
				$forma_pago="01";
				$nombre_responsable=$reg["nombre_persona"];
				$estado=$reg["estado"];
	}
	//$res2=ejecuta_query($sql);
	//echo $res2;
}

if($evento=='NEW'){
	//CALCULAMOS LOS NUEVOS CODIGOS PROVIONALES DE LA OPERACION
	$codigo_temp="";
	$tipo='PROF';
	$secuencial_temp=1;
	$guia_remision="ABIERTO";
	$sql="SELECT substring(cast((1000000000 + (coalesce(max(cast(secuencial as integer)),0) + 1)) as varchar) from 2 for 9) as secuencia 
	FROM inv.operacion 
	where ambiente='".get_sesion("ambiente")."' and empresa='".get_sesion("empresa")."' and periodo='".get_sesion("periodo")."' 
	and sucursal='".get_sesion("sucursal")."' and tipo='PROF' ;";
	$res=pg_query($conn,$sql);
	if($reg=pg_fetch_array($res)){$secuencial_temp=$reg["secuencia"];} 
	$secuencial_temp=$secuencial_temp;
	$num_filas=50;
	$proceso_new="add_varios_item(".$num_filas.");";
	$fecha=date("d")."/".date("m")."/".date("Y");
	$forma_pago="01";
	$bodega="1";
	$lista_precio="1";
	$por_iva_fact="12";
	$nombre_responsable=get_sesion("nombre_persona");
	$punto_emision=get_sesion("punto_emision");
	$valor_total="0.00";
}
?>
<script >
	var muestra_botones=true;
	var aux_guardar=false;
	function anular_meza(){
			//primero identificar el estado del pedido.
			if($("#guia_remision").val()=='CERRADO'){
				mensaje('El pedido ya fue facturado..!');
				return true;
			}
			if($("#guia_remision").val()=='ANULADO'){
				mensaje('El pedido ya fue Anulado..!');
				return true;
			}
			pregunta('Esta seguro de Anular el Pedido,<br>Si lo hace no de podran editar los datos del pedido...');
			$("#btn_pregunta_si").unbind('click');
			$("#btn_pregunta_si").click(function (){
				//alert('aqui');
				$("#accion_contenido").attr('value','anular_meza');
				$("#gif_cargando").css('visibility','visible');
				$.ajax({ 
					type: 'POST',
					async: true,  
					data: $('#form_windows_center').serialize() + "&"+ $('#form_windows').serialize(),
					url: "datos_contenido.php",  
					success: function(data) { 
						$('#sis_resultado').html(data);
						//setInterval(function () {validar_obj('form_windows_center');}, 3000);
						$("#gif_cargando").css('visibility','hidden');
					}  
				});
				cerrar_pregunta();
			});
			
	}
	function limpia_meza(){
			//primero identificar el estado del pedido.
			if($("#guia_remision").val()=='POR COBRAR'){
				mensaje('El pedido ya se encuentra fuera de la mesa..!');
				return true;
			}
			if($("#guia_remision").val()=='CERRADO'){
				mensaje('El pedido ya fue facturado..!');
				return true;
			}
			if($("#guia_remision").val()=='ANULADO'){
				mensaje('El pedido ya fue Anulado..!');
				return true;
			}
			pregunta('Esta seguro de limpiar la mesa,<br>Si lo hace no podra editar los datos del pedido con este usuario...');
			$("#btn_pregunta_si").unbind('click');
			$("#btn_pregunta_si").click(function (){
				//alert('aqui');
				$("#accion_contenido").attr('value','limpia_meza');
				$("#gif_cargando_principal").show();
				$.ajax({ 
					type: 'POST',
					async: true,  
					data: $('#form_windows_center').serialize() + "&"+ $('#form_windows').serialize(),
					url: "datos_contenido.php",  
					success: function(data) { 
						$('#sis_resultado').html(data);
						//setInterval(function () {validar_obj('form_windows_center');}, 3000);
						$("#gif_cargando_principal").hide();
					}  
				});
				cerrar_pregunta();
			});
			
	}
	function res_busca_producto(id,obj){
			//$("#gif_cargando").css('visibility','visible');
			//var color=$("#"+obj).css( "background-color" );
			//alert(color);
			//$("#"+obj).hide();
			var num_obj=obj.replace("cmd_busca_prod", "");
			$("#ico_visto_rpducto"+num_obj).show();
			$("#accion_windows").val('selec_producto'); 
			$.ajax({ 
					type: 'POST',
					async: false, 
					data: $('#form_windows').serialize(),
					url: "datos_windows.php?op=producto&codigo="+id,  
					success: function(data) {  
						$('#sis_resultado').html(data);
						//cerrar_busqueda(); 
						//$("#gif_cargando").css('visibility','hidden');
					}  
				});

	}
	
	function busca_producto(){
			abrir_busqueda('producto');
	}
	function suma_prod(obj){
		var num_obj=obj.replace("cmd_mas", "");
		var id_td="td_cant_detalle"+num_obj;
		$("#fila_item"+num_obj+" input").each(function (index) {
				if($(this).attr("id")=='cant_detalle[]'){
					var cantidad=Number($(this).val());
					cantidad=cantidad+1;
					$(this).val(cantidad);
					$("#"+id_td).html(cantidad);
				}
				//
		});
		calcular_todo('');
	}
	function resta_prod(obj){
		var num_obj=obj.replace("cmd_menos", "");
		var id_td="td_cant_detalle"+num_obj;
		var cantidad=0;
		var estado=$("#estado").val();
		var indice_detalle='';
		var cantidad_old=-1;
		$("#fila_item"+num_obj+" input").each(function (index) {if($(this).attr("id")=='indice_detalle[]'){	indice_detalle=$(this).val();}});
		
		
		if( estado=='print'){
			if (indice_detalle!='') { 
				$("#fila_item"+num_obj+" input").each(function (index) {if($(this).attr("id")=='cant_detalle_old[]'){	cantidad_old=Number($(this).val());}});
			}
		}
		//mensaje(cantidad_old);
		//return false;
		$("#fila_item"+num_obj+" input").each(function (index) {
				if($(this).attr("id")=='cant_detalle[]'){
					cantidad=Number($(this).val());
					if(cantidad_old!=-1){
						if(cantidad==cantidad_old){mensaje('Accion no permitida'); return false;}
					}
					cantidad=cantidad - 1;
					$(this).val(cantidad);
					$("#"+id_td).html(cantidad);
				}
				//
		});
		if(cantidad==0){
			$("#fila_item"+num_obj).remove();
		}
		calcular_todo('');
	}
	function calcular_todo(op){
				var toal_sin_impuestos=0;
				var cantidad=0;
				var precio=0;
				var desto=0;
				var total_detalle=0;
				var aplica_iva='';
				var por_iva=0; // porcentahe de iva
				var por_desto=0; // porcentahe de iva
				var val_iva=0;
				var total_iva=0;
				var total_ivasi=0;
				var total_ice=0;
				var total_irbpnr=0;
				var total_iva0=0;
				var total_ivano=0;
				var total_ivaex=0;
				var total_a_pagar=0;
				var total_desto=0;
				//alert('yo');
				if(op=='calcula_desto'){por_desto=Number($("#por_desto").val());}
				$("#tabla_detalle tr").each(function (index) {
					cantidad=0;
					precio=0;
					desto=0;
					val_iva=0
					if($(this).attr("id")!='fila_item'){
						//alert('yo');
						$("#"+$(this).attr("id")+" input").each(function (index) {
							if($(this).attr("id")=='cant_detalle[]'){if($(this).val()!=''){cantidad=Number($(this).val());}	}
							if($(this).attr("id")=='precio_detalle[]'){if($(this).val()!=''){precio=Number($(this).val());}	}
							if($(this).attr("id")=='desto_detalle[]'){if($(this).val()!=''){desto=Number($(this).val());}	}
							if($(this).attr("id")=='aplica_iva[]'){if($(this).val()!=''){aplica_iva=$(this).val();}	}
							if($(this).attr("id")=='por_iva[]'){if($(this).val()!=''){por_iva=Number($(this).val());}}
							if(op=='calcula_desto'){
								if($(this).attr("id")=='por_desto_detalle[]'){$(this).val(por_desto);}
							}
						});	
						if(op=='calcula_desto'){
								desto=(cantidad * precio) * por_desto /100;
						}else{
							if(Number($("#por_desto").val())>0){
								por_desto=Number($("#por_desto").val());
								desto=(cantidad * precio) * por_desto /100;
							}
						}
						total_detalle=(cantidad * precio) - desto;
						if(aplica_iva=='2'){//CODIGO SRI INDICA QUE GRAVA IVA
							total_ivasi= Number(total_ivasi.toFixed(_ND_)) + Number(total_detalle.toFixed(_ND_));
							val_iva=Number((total_detalle * por_iva / 100).toFixed(_ND_));
							total_iva= Number(total_iva.toFixed(_ND_)) + Number((total_detalle * por_iva / 100).toFixed(_ND_));
						}
						//codigo SRI IVA 0%
						if(aplica_iva=='0'){total_iva0= Number(total_iva0.toFixed(_ND_)) + Number(total_detalle.toFixed(_ND_));}
						// CODIGO SRI NO OBJETO DE IMPUESTO
						if(aplica_iva=='6'){total_ivano= Number(total_ivano.toFixed(_ND_)) + Number(total_detalle.toFixed(_ND_));}
						// CODIGO SRI EXENTO DE IVA
						if(aplica_iva=='7'){total_ivaex= Number(total_ivaex.toFixed(_ND_)) + Number(total_detalle.toFixed(_ND_));}
						toal_sin_impuestos=Number(toal_sin_impuestos.toFixed(_ND_)) + Number(total_detalle.toFixed(_ND_));
						total_desto=Number(total_desto.toFixed(_ND_)) + Number(desto.toFixed(_ND_));
						$("#"+$(this).attr("id")+" input").each(function (index) {
							if($(this).attr("id")=='total_detalle[]' && cantidad>0){$(this).val(total_detalle.toFixed(_ND_));}
							//if(op=='calcula_desto'){
								if($(this).attr("id")=='desto_detalle[]' && cantidad>0){$(this).val(desto.toFixed(_ND_));}
							//}
							if($(this).attr("id")=='val_iva[]' && cantidad>0){$(this).val(val_iva.toFixed(_ND_));}
						});
					}
 				});
				//alert('yo');
				$("#sub_toal_iva12").val(total_ivasi.toFixed(_ND_));
				$("#sub_toal_iva0").val(total_iva0.toFixed(_ND_));
				$("#sub_toal_noiva").val(total_ivano.toFixed(_ND_));
				$("#sub_toal_exiva").val(total_ivaex.toFixed(_ND_));
				$("#sub_toal_fact").val(toal_sin_impuestos.toFixed(_ND_));
				$("#total_desto").val(total_desto.toFixed(_ND_));
				$("#val_imp_ice").val(total_ice.toFixed(_ND_));
				$("#val_imp_iva").val(total_iva.toFixed(_ND_));
				$("#imp_irbpnr").val(total_irbpnr.toFixed(_ND_));
				total_a_pagar = Number(toal_sin_impuestos.toFixed(_ND_)) + Number(total_ice.toFixed(_ND_)) + Number(total_iva.toFixed(_ND_)) + Number(total_irbpnr.toFixed(_ND_));
				$("#val_total_fact").val(total_a_pagar.toFixed(_ND_));
				//$("#total_operacion").val(total_a_pagar.toFixed(_ND_));
				$("#txt_val_total_fact").html(total_a_pagar.toFixed(_ND_));
				
			}
	
	function asigna_datos_fila(pcodigo_barra,pprod_detalle,paplica_iva,ppor_iva,ppor_desto_detalle,pval_iva,pdesc_detalle,pprecio_detalle,pdesto_detalle){
			var num_op=new Number($("#num_op").val());
			num_op=num_op+1;
			$("#num_op").val(num_op);
			var new_fila="<tr id='fila_item"+num_op+"' >" + $("#fila_item").html() + "</tr>";
			$("#tabla_detalle").append(new_fila);
			var num_filas=$("#tabla_detalle >tbody >tr").length;
			num_filas =num_filas - 1; //restamos la fila base
			$("#fila_item"+num_op+" td").each(function (index) {
				if($(this).attr("id")=='num_item'){$(this).html(num_filas);}
				if($(this).attr("id")=='td_desc_detalle'){$(this).html(pdesc_detalle);}
				if($(this).attr("id")=='td_cant_detalle'){$(this).attr("id",'td_cant_detalle'+num_op);$(this).html('1');}
 			});
			$("#fila_item"+num_op+" a").each(function (index) {
				if($(this).attr("id")=='cmd_mas'){$(this).attr("id",'cmd_mas'+num_op);}
				if($(this).attr("id")=='cmd_menos'){$(this).attr("id",'cmd_menos'+num_op);}
				if($(this).attr("id")=='cmd_desc_detalle'){$(this).attr("id",'cmd_desc_detalle'+num_op);}
 			});
			$("#fila_item"+num_op+" input").each(function (index) {
				if($(this).attr("id")=='codigo_detalle[]'){
					$(this).keypress(function(e) { return valida_enter(e,$(this).attr("id"),num_op)});
					$(this).val(pcodigo_barra);
				}
				if($(this).attr("id")=='cod_barra_detalle[]'){$(this).val(pcodigo_barra);}
				if($(this).attr("id")=='prod_detalle[]'){$(this).val(pprod_detalle);}
				if($(this).attr("id")=='aplica_iva[]'){$(this).val(paplica_iva);}
				if($(this).attr("id")=='por_iva[]'){$(this).val(ppor_iva);}
				if($(this).attr("id")=='por_desto_detalle[]'){$(this).val(ppor_desto_detalle);}
				if($(this).attr("id")=='val_iva[]'){$(this).val(pval_iva);}
				if($(this).attr("id")=='desc_detalle[]'){$(this).val(pdesc_detalle);}
				
				if($(this).attr("id")=='cant_detalle[]'){
					$(this).change(function(){ calcular_todo('');});
					$(this).val(1);
				}
				if($(this).attr("id")=='precio_detalle[]'){
					$(this).change(function(){ calcular_todo('');});
					$(this).val(pprecio_detalle);
				}
				if($(this).attr("id")=='desto_detalle[]'){
					$(this).change(function(){ calcular_todo('');});
					$(this).val(pdesto_detalle);
				}
				if($(this).attr("id")=='total_detalle[]'){$(this).val(pprecio_detalle);		}
 			});
			calcular_todo('');
		}
	function mas_botones(){
		if(muestra_botones==true)
			{	$("#div_mas_botones").show();
				$("#boton_mas_menos").html('<span class="ti-angle-double-up"></span>');
				
			}
		if(muestra_botones==false)
			{	$("#div_mas_botones").hide();
				$("#boton_mas_menos").html('<span class="ti-angle-double-down"></span>');
			}
		muestra_botones=!muestra_botones;
	}
	function edit_detalle(obj){
		var num_obj=obj.replace("cmd_desc_detalle", "");
		var desc_detalle="";
		var cantidad=0;
		var precio=0.00;
		$("#id_fila_edit_detalle").val(num_obj);
			//alert($("#id_fila_edit_detalle").val());
		$("#fila_item"+num_obj+" input").each(function (index) {
			if($(this).attr("id")=='desc_detalle[]'){	desc_detalle=$(this).val();	}	
			if($(this).attr("id")=='cant_detalle[]'){	cantidad=Number($(this).val());	}
			if($(this).attr("id")=='precio_detalle[]'){	precio=Number($(this).val());	}
		});
		
		$("#span_cantidad").html(cantidad);
		$("#span_precio").html(precio.toFixed(_ND_));
		$("#textarea_detalle").val(desc_detalle);
	}
	function guardar_detalle(){
		var desc_detalle=$("#textarea_detalle").val().toUpperCase();
		var num_obj=$("#id_fila_edit_detalle").val();
		//alert(desc_detalle);
		$("#fila_item"+num_obj+" input").each(function (index) {if($(this).attr("id")=='desc_detalle[]'){	$(this).val(desc_detalle);}	});
		$("#fila_item"+num_obj+" td").each(function (index) {	if($(this).attr("id")=='td_desc_detalle'){	$(this).html(desc_detalle);}});
		$("#boton_cerrar_detalle").click();
	}
	function guardar_fact(){
			if(aux_guardar==false){
				//alert(validar_obj_form('form_windows'));
				$("#gif_cargando_principal").show();
				aux_guardar=true;
				$("#accion_windows").attr('value','guardar');
				$.ajax({ 
						type: 'POST',
						async: true, 
						data: $('#form_windows').serialize() + "&"+$('#form_windows_center').serialize(),
						url: "acciones_windows.php",  
						success: function(data) { 
							$('#sis_resultado').html(data);
							aux_guardar=false;
							$("#gif_cargando_principal").hide();
						}  
				});
			}else{mensaje('Se esta ejecutando un proceso...<br> Espere un momento por favor... ');}
	}
</script>
<style>
.sin_before::before { height:0px;width:0px;}
.sin_before::after { height:0px;width:0px;}
</style>

 <form id="form_windows" name="form_windows">
	<input type="hidden" id="opcion_windows" name="opcion_windows" value="<?php echo $opcion_win;?>"/>
	<input type="hidden" id="accion_windows" name="accion_windows" value=""/>
    <input type="hidden" id="evento_windows" name="evento_windows" value="<?php echo $evento;?>"/>
    <input type="hidden" id="item_windows" name="item_windows" value="<?php echo $item;?>"/>
    <input type="hidden" id="fila_actual" name="fila_actual" value=""/>
    <input type="hidden" id="consulta_correo" name="consulta_correo" value=""/>
	<input type="hidden"  name="secuencial" id="secuencial" value="<?php echo $secuencial; ?>" />
	<input type="hidden"  name="responsable" id="responsable" value="<?php echo $responsable; ?>" />
	<input type="hidden"  name="fecha" id="fecha"   value="<?php echo $fecha; ?>" />
	<input type="hidden"  name="estado" id="estado"   value="<?php echo $estado; ?>" />
	<div class="card" >
		<div class="card-body" style="padding-bottom:2px;">
				<div class="row form-group" >
					<div class="col col-sm-11" >
						<h4 ><strong>Registro Pedido <span id="gif_cargando_principal" class="l-btn-icon cargando_mini" style="display:none;" > </span></strong></h4>
					</div>
					<div class="col col-sm-1" >
					<a href="javascript:void(0)" onclick="CerrarForm()" type="button" class="close" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</div>
				</div>
				<a href="javascript:void(0)" onclick="guardar_fact();" class="btn btn-primary btn-sm">Guardar</a>
				<a href="javascript:void(0)" onclick="busca_producto();" class="btn btn-success btn-sm" data-toggle="modal" data-target="#frm_busqueda">Mas productos</a>
				<a href="javascript:void(0)" onclick="limpia_meza()" class="btn btn-warning btn-sm ">Limpiar</a>
		</div>
		<div class="card-body" style="padding-top: 2px;">
			<div class="form-group">
				<label for="cc-exp" class="control-label mb-1">Mesa</label>
				<select id="caja" name="caja" name="select" id="select" class="form-control cc-exp">
						<option value="-1">--Selecciones Mesa--</option>
						<?php $sql="select codigo,nombre from fact.mesa where empresa='".get_sesion("empresa")."' and sucursal='".get_sesion("sucursal")."' and
							codigo not in (select caja from inv.operacion where empresa ='".get_sesion("empresa")."' and sucursal='".get_sesion("sucursal")."' and guia_remision='ABIERTO' and referencia<>'ORDEN' 
							and caja<>'".$caja."') 
						 order by nombre";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>
				<option <?php if($reg["codigo"]==$caja) { echo "selected='selected'";}?> 
				value="<?php echo $reg["codigo"];?>" ><?php echo $reg["nombre"];?></option>
				<?php } ?>
				</select>
			</div>
			<?php $num_op=0;
			include("detalle_item.php");
			?>	
		</div> 
	</div> <!-- /.card -->
	<input name="val_diferencia" id="val_diferencia" type="hidden"  value="0" />
	<input name="val_efectivo" id="val_efectivo" type="hidden"  value="0"/>
	<input name="sub_toal_iva12" id="sub_toal_iva12" type="hidden" value="<?php echo $sub_total12; ?>"/>
	<input name="sub_toal_iva0" id="sub_toal_iva0" type="hidden" value="<?php echo $sub_total0; ?>" />
	<input name="sub_toal_noiva" id="sub_toal_noiva" type="hidden" value="<?php echo $sub_total_noiva; ?>" />
	<input name="sub_toal_exiva" id="sub_toal_exiva" type="hidden" value="<?php echo $sub_total_exentos; ?>" />
	<input name="sub_toal_fact" id="sub_toal_fact" type="hidden" value="<?php echo $sub_total; ?>" />
	<input name="total_desto" id="total_desto" type="hidden" value="<?php echo $total_desto; ?>" />
	<input name="val_imp_ice" id="val_imp_ice" type="hidden" value="<?php echo $val_ice; ?>" />
	<input name="val_imp_iva" id="val_imp_iva" type="hidden" value="<?php echo $val_iva; ?>" />
	<input name="imp_irbpnr" id="imp_irbpnr" type="hidden" value="<?php echo $val_irbpnr; ?>" />
	<input name="val_total_fact" id="val_total_fact" type="hidden"  value="<?php echo $valor_total; ?>" />
	<input name="num_op" id="num_op" type="hidden" value="<?php echo $num_op; ?>" />
	<input name="codigo" id="codigo" type="hidden"  value="<?php echo $codigo; ?>" />
    <input name="por_iva_fact" id="por_iva_fact" type="hidden" value="<?php echo $por_iva_fact; ?>" />
    <input name="punto_emision" id="punto_emision" type="hidden"  value="<?php echo $punto_emision; ?>" />
    <input name="contador" id="contador" type="hidden"  value="0" />
    <input name="tipo_op" id="tipo_op" type="hidden"  value="<?php echo $tipo; ?>" />
    <input name="guia_remision" id="guia_remision" type="hidden"  value="<?php echo $guia_remision; ?>" />
	<input name="lista_precio" id="lista_precio" type="hidden"  value="<?php echo $lista_precio; ?>" />
	<input name="bodega" id="bodega" type="hidden"  value="<?php echo $bodega; ?>" />
</form>

<div class="modal fade" id="frm_edit_edtalle" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
				<div class="modal-header">
					<div class="row form-group">
						<div class="col col-sm-10">
							<h3 >Cantidad : <span id="span_cantidad" class="badge badge-secondary"></span></h3>
						</div>
						<div class="col col-md-2">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3"><label for="textarea-input" class=" form-control-label">Descripcion del producto</label></div>
						<div class="col-12 col-md-9">
						<textarea id="textarea_detalle" name="textarea-input" rows="7" class="form-control" style="text-transform: uppercase;" ></textarea>
						</div>
						<input name="id_fila_edit_detalle" id="id_fila_edit_detalle" type="hidden"  value="" />
					</div>
				</div>
				<div class="card-header" style="text-align: right;padding-top: 2px;" >
					<h3 >Precio : <span id="span_precio" class="badge badge-secondary"></span></h3>
				</div>
				<div class="modal-footer">
					<div class="col col-sm-6" align="right">
						<a href="javascript:void(0)" onclick="guardar_detalle()" class="btn btn-info btn-sm btn-block" >Guardar</a>
					</div>
					<div class="col col-sm-6" align="right">
						<button id="boton_cerrar_detalle" type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
					</div
				</div>
		</div>
	</div>
</div>


