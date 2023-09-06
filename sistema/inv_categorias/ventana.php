<?php 
$opcion_win=$_POST["opcion_contenido"];
$evento=$_POST["evento_contenido"];
$item=$_POST["item_contenido"];
$ref_conenido=$_POST["ref_contenido"];
//$evento=$_POST["evento_windows"];
//$item=$_POST["item_windows"];
$estado="1";
$validado="NO";
if($evento=='EDIT'){
	$codigo=$item;
	$sql="SELECT * from inv.categoria where empresa='".get_sesion("empresa")."' and  cuenta='".get_sesion("id_cuenta")."' and codigo='".$codigo."' ";
	//echo $sql;
	$res=pg_query($conn,$sql);
	//if(pg_num_rows($res)!=0){ 
	if($reg=pg_fetch_array($res)){;
		//$res=mysql_query($sql, $Conn);
		$codigo=$reg["codigo"];
		$nombre=$reg["nombre"];
	}
}

?>
<script type="text/javascript">

		function nuevo_item(){
			var num_op=new Number($("#num_op").attr('value'));
			num_op=num_op+1;
			$("#num_op").attr('value',num_op);
			var new_fila="<tr id='fila_sub_categoria"+num_op+"' >" + $("#fila_sub_categoria").html() + "</tr>";
			$("#tabla_sub_categoria").append(new_fila);
			$("#fila_sub_categoria"+num_op+" a").each(function (index) {
				if($(this).attr("id")=='cmd_remove_item'){$(this).attr("id",'cmd_remove_item'+num_op);}
 			});
		}
		function remove_item(obj){
			var num_obj=obj.replace("cmd_remove_item", "");
			$("#fila_sub_categoria"+num_obj).remove();
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
						<!--<a href="javascript:void(0)" onclick="CerrarForm()" class="btn btn-danger btn-sm " style="float:right;">
						<i class="fa fa-times"></i></a> -->
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
					<label class=" form-control-label">ID Sistema :</label>
				</div>
				<div class="col col-md-9">
					<span  class="badge badge-secondary"><?php echo $codigo; ?></span>
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Nombre :</label></div>
				<div class="col-12 col-md-9">
					<input type="text" id="nombre" maxlength="50" name="nombre" placeholder="Nombre de categoria" 
					class="form-control" value="<?php echo $nombre; ?>">
				</div>
			</div>
            <div class="row form-group">
            	<div class="col-lg-12">
                    <div class="card" style=" padding:2px;">
                        <div class="card-header" style=" padding:2px;">
                            <strong class="card-title">Sub Categorias</strong>
                            <a  href="javascript:void(0)" onclick="nuevo_item()" class="btn-sm btn-success " style="float:right" >Agregar</a>
                        </div>
                        <div class="card-body" style=" padding:2px;">
                            <table class="table"  id="tabla_sub_categoria">
                              <tbody>
                              		<tr id="fila_sub_categoria" style=" display:none;">
                                        <td>
                                        	<div class="input-group">
                                            	<input name="sub_categoria[]" id="sub_categoria[]"  placeholder="Nombre de Sub categoria" type="text" class="form-control" value="" />
                                                <div class="input-group-btn">
                                                        <a id="cmd_remove_item" class="btn btn-danger" href="javascript:void(0)" onclick="remove_item(this.id);">
                                                            <i class="fa fa-trash-o"></i> 
                                                        </a>
                                                </div>
                                                
                                            </div>
                                            <input id="codigo_sub_categoria[]" name="codigo_sub_categoria[]" type="hidden" value="" />
                                        </td>
                                    </tr>
                                 	<?php $sql="select * from inv.sub_categoria where empresa='".get_sesion("empresa")."' 
										 and cuenta='".get_sesion("id_cuenta")."' and categoria='".$codigo."' order by nombre";
                                    //echo $sql;
									$num_op=0;
                                    $res=pg_query($conn,$sql);
                                    while ($reg=pg_fetch_array($res)){$num_op++;?>
                                    <tr id="fila_sub_categoria<?php echo $num_op; ?>">
                                        <td>
                                        	<div class="input-group">
                                            	<input name="sub_categoria[]" id="sub_categoria[]" placeholder="Nombre de Sub categoria" type="text" 
                                                class="form-control" value="<?php echo $reg["nombre"]; ?>" />
                                                <div class="input-group-btn">
                                                        <a id="cmd_remove_item<?php echo $num_op; ?>" class="btn btn-danger" href="javascript:void(0)" onclick="remove_item(this.id);">
                                                            <i class="fa fa-trash-o"></i> 
                                                        </a>
                                                </div>
                                            </div>
                                            <input id="codigo_sub_categoria[]" name="codigo_sub_categoria[]" type="hidden" value="<?php echo $reg["codigo"];?>" />
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
    <input name="num_op" id="num_op" type="hidden" value="0" />
</form>