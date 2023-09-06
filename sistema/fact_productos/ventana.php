<?php 
$opcion_win=$_POST["opcion_contenido"];
$evento=$_POST["evento_contenido"];
$item=$_POST["item_contenido"];
$ref_conenido=$_POST["ref_contenido"];

//$evento=$_POST["evento_windows"];
//$item=$_POST["item_windows"];
$estado="1";
$validado="NO";
$borrado="N";
$num_partes=0;
$kardex="P";
$valida_stock="N";

if($evento=='EDIT'){
	$codigo=$item;
	$sql="select p.*,coalesce((select nombre from inv.producto where codigo=p.producto_padre and empresa=p.empresa and cuenta=p.cuenta),'') as nombre_producto_padre 
	from inv.producto p where p.codigo='".$codigo."' and p.empresa='".get_sesion("empresa")."' and  cuenta='".get_sesion("id_cuenta")."'";
	//echo $sql;
	$res=pg_query($conn,$sql);
	//if(pg_num_rows($res)!=0){ 
	if($reg=pg_fetch_array($res)){;
		//$res=mysql_query($sql, $Conn);
		$codigo=$reg["codigo"];
		$nombre=utf8_decode($reg["nombre"]);
		$codigo_barra=$reg["codigo_barra"];
		$descripcion=utf8_decode($reg["descripcion"]);
		$precio=$reg["precio"];
		$tipo=$reg["tipo"];
		$unidad=$reg["unidad"];
		$categoria=$reg["categoria"];
		$sub_categoria=$reg["sub_categoria"];
		$marca=$reg["marca"];
		$modelo=$reg["modelo"];
		$aplica_iva=$reg["aplica_iva"];
		$aplica_ice=$reg["aplica_ice"];
		$aplica_irbpnr=$reg["aplica_irbpnr"];
		$componente=$reg["componente"];
		$producto_padre=$reg["producto_padre"];
		$num_partes=$reg["num_partes"];
		$borrado=$reg["borrado"]; //
		$nombre_producto_padre=utf8_decode($reg["nombre_producto_padre"]);
		$kardex=$reg["kardex"];
		$valida_stock=$reg["valida_stock"];
	}
}
if($evento=='NEW'){ $kardex='P';}
?>
<script type="text/javascript">

		function calcular_precios(){
			var precio=$("#precio").val();
			$("#tabla_precios ").each(function (index) {
				var num_op=$(this).attr("id");
				var margen=0;
				var precio_actual=0;
				var aplica_iva=$("#aplica_iva").val();
				var val_iva=0;
				if(aplica_iva=='2'){val_iva=0.12;}
				$("#"+num_op+" input").each(function (index) {
						if($(this).attr("id")=='lista_margen[]'){margen=$(this).val();}
						if($(this).attr("id")=='lista_precio[]'){
							var new_precio=Number(precio) + Number((precio * margen) / 100);
							precio_actual=new_precio.toFixed(5);
							$(this).val( new_precio.toFixed(5));
						}
						if($(this).attr("id")=='pvp[]'){
							precio_actual =precio_actual *(1 + val_iva);
							$(this).val( precio_actual.toFixed(5));
						}
				});
				
			});
		}
		function calcular_desdepvp(tr){
			var pvp=0;
			var aplica_iva=$("#aplica_iva").val();
			var val_iva=0;
			if(aplica_iva=='2'){val_iva=0.12;}
			$("#"+tr+" input").each(function (index) {
						if($(this).attr("id")=='pvp[]'){
								pvp=Number($(this).val());
						}
				});
			$("#"+tr+" input").each(function (index) {
						if($(this).attr("id")=='lista_precio[]'){
							var new_precio=Number(pvp) / (1 + val_iva);
							$(this).val( new_precio.toFixed(5));
						}
				});
			}
		function calcular_desdeprecio(tr){
			var precio=0;
			var aplica_iva=$("#aplica_iva").val();
			var val_iva=0;
			if(aplica_iva=='2'){val_iva=0.12;}
			$("#"+tr+" input").each(function (index) {
						if($(this).attr("id")=='lista_precio[]'){
								precio=Number($(this).val());
						}
				});
			$("#"+tr+" input").each(function (index) {
						if($(this).attr("id")=='pvp[]'){
							var new_precio=Number(precio) * (1 + val_iva);
							$(this).val( new_precio.toFixed(5));
						}
				});
			}
		function res_busca_producto(id){
			//cerrar_busqueda(); 
			//return false;
			$("#gif_cargando").css('visibility','visible');
			$("#accion_windows").val('selec_producto'); 
			$("#op_busca_windows").val('producto'); 
			$("#item_busca_windows").val(id); 
			$.ajax({ 
					type: 'POST',
					async: false, 
					data: $('#form_windows').serialize(),
					url: "datos_windows.php?op=producto",  
					success: function(data) {  
						$('#sis_resultado').html(data);
						cerrar_busqueda(); 
						$("#gif_cargando").css('visibility','hidden');
					}  
				});

		}
		function limpia_producto(){
			$('#nombre_producto_padre').val('');
			$('#producto_padre').val('');	
		
		}
</script>
<form id="form_windows" name="form_windows">
	<input type="hidden" id="opcion_windows" name="opcion_windows" value="<?php echo $opcion_win;?>"/>
	<input type="hidden" id="accion_windows" name="accion_windows" value=""/>
    <input type="hidden" id="evento_windows" name="evento_windows" value="<?php echo $evento;?>"/>
    <input type="hidden" id="item_windows"  name="item_windows" value="<?php echo $item;?>"/>
    <input type="hidden" id="item_busca_windows"  name="item_busca_windows" value=""/>
    <input type="hidden" id="op_busca_windows"  name="op_busca_windows" value=""/>
	<div class="card" >
		<div class="card-body" style="padding-bottom:2px;">
				<div class="row form-group" >
					<div class="col col-sm-11" >
						<h4 ><strong><?php echo $ref_conenido; ?> <span id="gif_cargando_principal" class="l-btn-icon cargando_mini" style="display:none;" > </span></strong></h4>
					</div>
					<div class="col col-sm-1" >
						<a href="javascript:void(0)" onclick="CerrarForm()" type="button" class="close" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</a>
					</div>
				</div>
				<div class="row form-group" >
					<div class="col col-sm-2" >
						<a href="javascript:void(0)" onclick="guardar();" class="btn btn-primary btn-sm btn-block">
							<i class="fa fa-save"></i><span class="btn">Guardar</span>
						</a>
					</div>
				</div>
		</div>
		<div class="card-body" style="padding-top: 2px;">
			<div class="row form-group">
				<div class="col col-md-3">
					<label class=" form-control-label">Codigo Sistema :</label>
				</div>
				<div class="col col-md-3">
                    <span  class="badge badge-secondary"><?php echo $codigo; ?></span>
				</div>
                <div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">Producto Activo :</label></div>
				<div class="col-12 col-md-3">
					<input type="checkbox" style="width:25px; height:25px;"   
					name="borrado" id="borrado"  value="1"  <?php if($borrado=="N"){echo "checked='checked'";} ?>> 
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Nombre :</label></div>
				<div class="col-12 col-md-9">
                	<input type="text" id="nombre" maxlength="150" name="nombre" onkeydown="" placeholder="Nombre del producto" 
                    class="form-control" value="<?php echo $nombre; ?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Descripcion :</label></div>
				<div class="col-12 col-md-9">
					<input type="text" id="descripcion" maxlength="300" name="descripcion" placeholder="Descripcion del producto" 
					class="form-control" value="<?php echo $descripcion; ?>">
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Precio costo :</label></div>
				<div class="col-12 col-md-3">
					<input type="number"   id="precio" maxlength="10" name="precio" placeholder="Precio costo" onchange="calcular_precios();"
					class="form-control" value="<?php echo $precio; ?>" style="text-align:right;">
				</div>
				<div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">Tipo producto:</label></div>
				<div class="col-12 col-md-3">
					<select name="tipo" id="tipo" class="form-control" >
                        <?php $sql="select codigo,valor from sis.catalogo where tipo='TP_PRODUCTO' order by valor";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>	<option <?php if($reg["codigo"]==$tipo) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["valor"];?> </option> <?php } ?>
					</select>
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Codigo de Barra :</label></div>
				<div class="col-12 col-md-3">
					<input type="text" id="codigo_barra" maxlength="30" name="codigo_barra" placeholder="Codigo de barra" 
					class="form-control" value="<?php echo $codigo_barra; ?>">
				</div>
				<div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">Valida Stock:</label></div>
				<div class="col-12 col-md-3">
					<select name="valida_stock" id="valida_stock" class="form-control" >
                        <?php $sql="select codigo,valor from sis.catalogo where tipo='S_N' order by valor";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>	<option <?php if($reg["codigo"]==$tipo) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["valor"];?> </option> <?php } ?>
					</select>
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Marca :</label></div>
				<div class="col-12 col-md-3">
					<input type="text"   id="marca" maxlength="100" name="marca" placeholder="marca de producto" 
					class="form-control" value="<?php echo $marca; ?>" >
				</div>
				<div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">Modelo:</label></div>
				<div class="col-12 col-md-3">
					<input type="text"   id="modelo" maxlength="100" name="modelo" placeholder="Modelo del producto" 
					class="form-control" value="<?php echo $modelo; ?>">
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Unidad medidad:</label></div>
				<div class="col-12 col-md-3">
					<select name="unidad" id="unidad" class="form-control" >
                        <?php $sql="select codigo,nombre from inv.unidad_medida where cuenta='".get_sesion("id_cuenta")."' and empresa='".get_sesion("empresa")."' order by nombre";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>	<option <?php if($reg["codigo"]==$unidad) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["nombre"];?> </option> <?php } ?>
					</select>
                    <?php //echo $sql;?>
				</div>
				<div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">Aplica IVA:</label></div>
				<div class="col-12 col-md-3">
					<select name="aplica_iva" id="aplica_iva" class="form-control" >
                        <?php //codigo_impuesto='2' se trata de IVA
						$sql="select codigo_adm as codigo, codigo_adm || ' - ' || descripcion as nombre from sis.impuesto_sri 
						where codigo_impuesto='2' and fecha_fin='NULL' and tipo_impuesto in('I','A') order by codigo_adm";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>	<option <?php if($reg["codigo"]==$aplica_iva) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["nombre"];?> </option> <?php } ?>
					</select>
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Aplica ICE:</label></div>
				<div class="col-12 col-md-3">
					<select name="aplica_ice" id="aplica_ice" class="form-control" >
                    	<option value="-1">No Aplica</option>
                        <?php $sql="select codigo as codigo, codigo || ' - ' || descripcion as nombre from sis.impuesto_sri 
					    where codigo_impuesto='3' and fecha_fin='NULL' and tipo_impuesto in('I','A') order by codigo";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>	<option <?php if($reg["codigo"]==$aplica_ice) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["nombre"];?> </option> <?php } ?>
					</select>
				</div>
				<div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">Aplica IRBPNR:</label></div>
				<div class="col-12 col-md-3">
					<select name="aplica_irbpnr" id="aplica_irbpnr" class="form-control" >
                    	<option value="-1">No Aplica</option>
                        <?php $sql="select codigo as codigo, codigo || ' - ' || descripcion as nombre from sis.impuesto_sri 
						where codigo_impuesto='5' and fecha_fin='NULL' and tipo_impuesto in('B') order by codigo";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>	<option <?php if($reg["codigo"]==$aplica_irbpnr) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["nombre"];?> </option> <?php } ?>
					</select>
				</div>
			</div>
             <div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Categoria:</label></div>
				<div class="col-12 col-md-3">
					<select name="categoria" id="categoria" class="form-control" onchange="carga_combo('categoria',new Array('sub_categoria'))" >
                    	<option  value="-1">--Seleccion--</option>
                    	<?php $sql="select codigo,nombre from inv.categoria where empresa='".get_sesion("empresa")."' order by nombre";
							$res=pg_query($conn,$sql);
							while ($reg=pg_fetch_array($res))
							{ ?>	<option <?php if($reg["codigo"]==$categoria) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["nombre"];?> </option> <?php } ?>
					</select>
				</div>
				<div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">Sub Categoria:</label></div>
				<div class="col-12 col-md-3" id="divsub_categoria" > 
					<select name="sub_categoria" id="sub_categoria" class="form-control" >
                    	<option value="-1" >--Seleccion--</option>
                    	<?php $sql="select codigo,nombre from inv.sub_categoria where empresa='".get_sesion("empresa")."' and categoria='".$categoria."' order by nombre";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>	<option <?php if($reg["codigo"]==$sub_categoria) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["nombre"];?> </option> <?php } ?>
					</select>
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Es componente:</label></div>
				<div class="col-12 col-md-3">
					<select name="componente" id="componente" class="form-control" >
                        <?php $sql="select codigo,valor from sis.catalogo where tipo='S_N' order by valor";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>	<option <?php if($reg["codigo"]==$componente) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["valor"];?> </option> <?php } ?>
					</select>
				</div>
                <div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">Numero de partes :</label></div>
				<div class="col-12 col-md-3">
					<input type="number"   id="num_partes" maxlength="10" name="num_partes" placeholder="numero de partes"  
                    class="form-control" value="<?php echo $num_partes; ?>" style="text-align:right;">
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Producto principal :</label></div>
				<div class="col-12 col-md-9">
                    <div class="input-group">
                        <input type="text"   id="nombre_producto_padre" name="nombre_producto_padre" placeholder="Producto padre" disabled="disabled" 
                         class="form-control" value="<?php echo $nombre_producto_padre; ?>">
                        <div class="input-group-btn">
                            <a class="btn btn-primary" href="javascript:void(0)" onclick="abrir_busqueda('producto')" data-toggle="modal" data-target="#frm_busqueda">
                                <i class="fa fa-search"></i> 
                            </a>
                        </div>
                        <div class="input-group-btn">
                            <a class="btn btn-primary" href="javascript:void(0)" onclick="limpia_producto()" >
                                <i class="fa fa-trash-o"></i> 
                            </a>
                        </div>
                        <input type='hidden' name='producto_padre' id="producto_padre" value='<?php echo $producto_padre;?>'>
					</div>
				</div>
			</div>
            <div class="row form-group">
<!--            	<div class="col col-md-6">-->
            		<div class="col-lg-6">
                        <div class="card" style=" padding:2px;">
                            <div class="card-header" style=" padding:2px;">
                                <strong class="card-title">Listas Precios</strong>
                            </div>
                            <div class="card-body" style=" padding:2px;">
                                <table class="table"  id="tabla_precios">
                                    <thead>
                                        <tr>
                                          <th scope="col">Lista</th>
                                          <th scope="col">Precio</th>
                                          <th scope="col">P.V.P</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                  	 <?php $sql="select li.nombre,li.codigo, li.margen,coalesce((select precio from fact.producto_precio where empresa=li.empresa 
										and producto='".$codigo."' 
										and li.codigo=lista_precio ),0.00000) as precio
										from fact.lista_precio li where li.en_uso='S' and li.empresa='".get_sesion("empresa")."' and li.cuenta='".get_sesion("id_cuenta")."' order by li.nombre ";
										//echo $sql;
										$res=pg_query($conn,$sql);
										while ($reg=pg_fetch_array($res)){?>
                                        <tr id="fila_precio<?php echo $reg["codigo"]; ?>">
                                            <td style="font-size:10px;">
                                            <?php echo $reg["nombre"]." (".$reg["margen"]."%)"; ?>
                                            <input name="lista_codigo[]" id="lista_codigo[]" type="hidden" value="<?php echo $reg["codigo"]; ?>" />
                                            <input name="lista_margen[]" id="lista_margen[]" type="hidden" value="<?php echo $reg["margen"]; ?>" />
                                            </td>
                                            <td>
                                                <input name="lista_precio[]" id="lista_precio[]" class="txtnumero"  style=" width:99%; text-align:right;"
                                                onchange="calcular_desdeprecio('fila_precio<?php echo $reg["codigo"]; ?>');" value="<?php echo $reg["precio"]; ?>" />
                                            </td>
                                            <td>
                                                <input name="pvp[]" id="pvp[]" class="txtnumero" style=" width:99%; text-align:right;" 
                                                onchange="calcular_desdepvp('fila_precio<?php echo $reg["codigo"]; ?>');" value="<?php echo truncar($reg["precio"]*1.12,5); ?>" />
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            	</table>
                        	</div>
                    	</div>
<!--                	</div>-->
                	</div>
            </div>
            
            
		</div> 
	</div> <!-- /.card -->
	<input type='hidden' name='codigo' id="codigo" value='<?php echo $codigo;?>'>	
    <input name="kardex" id="kardex" type="hidden" value="<?php echo $kardex; ?>" />

</form>