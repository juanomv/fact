		
<div id="div_tabla_detalle" class="table-stats order-table ov-h sin_before" style="padding:2px;">
	 <table class="table" id="tabla_detalle" style="padding:2px;">
		<thead style="padding:2px;">
			<tr style="padding:2px;">
				<th style="padding:2px;">Cant</th>
				<th style="padding:2px;">Producto</th>
				<th style="padding:2px;">Edit</th>
				<th style="padding:2px;">Mas</th> 
				<th style="padding:2px;">Menos</th>
			</tr>
		</thead>
		<tbody id="my_tbody" style="padding:2px;">
			<tr id="fila_item" style=" display:none; padding:2px;">
				<td id="td_cant_detalle" style="padding:2px;"></td>
				<td id="td_desc_detalle" style="padding:2px;"></td >
				<td style="padding:2px;">
					<a id="cmd_desc_detalle" href="javascript:void(0)" onclick="edit_detalle(this.id);" class="btn btn-info btn-sm" 
						data-toggle="modal" data-target="#frm_edit_edtalle" ><i class="fa fa-check"></i>
					</a>
				</td>
				<td style="padding:2px;">
					<a id="cmd_mas" href="javascript:void(0)" onclick="suma_prod(this.id)" class="btn btn-success btn-sm active btn-move">( + )</a>
					<input id="codigo_detalle[]" name="codigo_detalle[]" type="hidden" />
					<input id="indice_detalle[]" name="indice_detalle[]" type="hidden" />
					<input id="cod_barra_detalle[]" name="cod_barra_detalle[]" type="hidden"/>
					<input id="prod_detalle[]" name="prod_detalle[]" type="hidden" />
					<input id="aplica_iva[]" name="aplica_iva[]" type="hidden" />
					<input id="por_iva[]" name="por_iva[]" type="hidden" />
					<input id="por_desto_detalle[]" name="por_desto_detalle[]" type="hidden" />
					<input id="val_iva[]" name="val_iva[]" type="hidden" />
					<input id="desc_detalle[]" name="desc_detalle[]" type="hidden" />
					<input id="cant_detalle[]" name="cant_detalle[]" type="hidden" />
					<input id="cant_detalle_old[]" name="cant_detalle_old[]" type="hidden" />
					<input id="precio_detalle[]" name="precio_detalle[]" type="hidden" />
					<input id="desto_detalle[]" name="desto_detalle[]" type="hidden" />
					<input id="total_detalle[]" name="total_detalle[]" type="hidden" />
				</td>
				<td style="padding:2px;">
					<a id="cmd_menos" href="javascript:void(0)" onclick="resta_prod(this.id)" class="btn btn-danger btn-sm active btn-move">( - )</a>
				</td>
			</tr>
			 <?php 
			
				if($evento=='EDIT'){
					$nd=get_sesion("_ND_");
					$sql="select 
					det.codigo,
					det.por_iva,
					det.producto, 
					det.aplica_iva,
					det.por_desto,
					trunc(det.total_iva,".$nd.") as total_iva,
					trunc(det.cantidad,0) as cantidad,
					det.precio,
					trunc(det.val_desto,".$nd.") as val_desto,
					trunc(det.total_detalle,".$nd.") as total_detalle,
					case coalesce(det.descripcion,'') when '' then prod.nombre else upper(det.descripcion) end as nombre,
					prod.codigo_barra 
					from inv.detalle_operacion det inner join inv.producto prod 
					on prod.empresa=det.empresa and prod.codigo=det.producto 
					where det.empresa='".get_sesion("empresa")."' and det.periodo='".get_sesion("periodo")."' 
					and det.sucursal='".get_sesion("sucursal")."' and det.tipo='".$tipo."' and det.operacion='".$codigo."' order by codigo";
					//echo $sql;
					$res=pg_query($conn,$sql);
					$num_op=0;
					while ($reg=pg_fetch_array($res)){ $num_op++;?>
					<tr id="fila_item<?php echo $num_op; ?>" style="padding:2px;">
						<td id="td_cant_detalle<?php echo $num_op; ?>" style="padding:2px;"><?php echo $reg["cantidad"];?></td>
						<td id="td_desc_detalle" style="padding:2px;"><?php echo $reg["nombre"];?></td >
						<td style="padding:2px;">
							<a id="cmd_desc_detalle<?php echo $num_op; ?>" href="javascript:void(0)" onclick="edit_detalle(this.id);" class="btn btn-info btn-sm" 
								data-toggle="modal" data-target="#frm_edit_edtalle" ><i class="fa fa-check"></i>
							</a>
						</td>
						<td style="padding:2px;">
							<a id="cmd_mas<?php echo $num_op; ?>" href="javascript:void(0)" onclick="suma_prod(this.id)" 
							class="btn btn-success btn-sm active btn-move">( + )</a>
							<input id="codigo_detalle[]" name="codigo_detalle[]" type="hidden" value="<?php echo $reg["codigo_barra"];?>" />
							<input id="indice_detalle[]" name="indice_detalle[]" type="hidden" value="<?php echo $reg["codigo"];?>" />
							<input id="cod_barra_detalle[]" name="cod_barra_detalle[]" type="hidden" value="<?php echo $reg["codigo_barra"];?>"/>
							<input id="prod_detalle[]" name="prod_detalle[]" type="hidden" value="<?php echo $reg["producto"];?>" />
							<input id="aplica_iva[]" name="aplica_iva[]" type="hidden" value="<?php echo $reg["aplica_iva"];?>" />
							<input id="por_iva[]" name="por_iva[]" type="hidden" value="<?php echo $reg["por_iva"];?>"/>
							<input id="por_desto_detalle[]" name="por_desto_detalle[]" type="hidden" value="<?php echo $reg["por_desto"];?>" />
							<input id="val_iva[]" name="val_iva[]" type="hidden" value="<?php echo $reg["total_iva"];?>"/>
							<input id="desc_detalle[]" name="desc_detalle[]" type="hidden" value="<?php echo $reg["nombre"];?>"/>
							<input id="cant_detalle[]" name="cant_detalle[]" type="hidden" value="<?php echo $reg["cantidad"];?>"/>
							<input id="cant_detalle_old[]" name="cant_detalle_old[]" type="hidden" value="<?php echo $reg["cantidad"];?>"/>
							<input id="precio_detalle[]" name="precio_detalle[]" type="hidden" value="<?php echo $reg["precio"];?>" />
							<input id="desto_detalle[]" name="desto_detalle[]" type="hidden" value="<?php echo $reg["val_desto"];?>"/>
							<input id="total_detalle[]" name="total_detalle[]" type="hidden" value="<?php echo $reg["total_detalle"];?>"/>
						</td>
						<td style="padding:2px;">
							<a id="cmd_menos<?php echo $num_op; ?>" href="javascript:void(0)" onclick="resta_prod(this.id)" 
							class="btn btn-danger btn-sm active btn-move">( - )</a>
						</td>
					</tr>
					<?php } //while ($reg=pg_fetch_array($res))
				} //if($evento=='EDIT'){
		  ?>
		</tbody>
	</table>  
</div>
<div class="card-header" style="text-align: right;">
	<h3 >Saldo : <span id="txt_val_total_fact" class="badge badge-secondary"><?php echo $valor_total; ?></span></h3>
</div>
