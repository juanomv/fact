<?php 
$opcion_win=$_POST["opcion_contenido"];
$evento=$_POST["evento_contenido"];
$item=$_POST["item_contenido"];
//$evento=$_POST["evento_windows"];
//$item=$_POST["item_windows"];
 
if($evento=='EDIT'){
	$codigo=$item;
	$sql="SELECT  * from sis.rol_usuario where codigo='".$codigo."' ";
	//echo $sql;
	$res=pg_query($conn,$sql);
	//if(pg_num_rows($res)!=0){ 
	if($reg=pg_fetch_array($res)){;
		//$res=mysql_query($sql, $Conn);
		//if($fila = mysql_fetch_array($res, MYSQL_ASSOC)){
			$codigo=$reg["codigo"];
			$nombre=$reg["nombre"];
			$nivel=$reg["nivel"];
			$mostrar=$reg["mostrar"];
	}
	//echo $codigo; 
}

?>
<form id="form_windows" name="form_windows">
	<input type="hidden" id="opcion_windows" name="opcion_windows" value="<?php echo $opcion_win;?>"/>
	<input type="hidden" id="accion_windows" name="accion_windows" value=""/>
    <input type="hidden" id="evento_windows" name="evento_windows" value="<?php echo $evento;?>"/>
    <input type="hidden" id="item_windows" name="item_windows" value="<?php echo $item;?>"/>
	<div class="card" >
		<div class="card-body" >
				<div class="row form-group" >
					<div class="col col-sm-11" >
						<h4 ><strong>Registro Roles <span id="gif_cargando_principal" class="l-btn-icon cargando_mini" style="display:none;" > </span></strong></h4>
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
		<div class="card-body" >
			<div class="row form-group">
				<div class="col col-md-3">
					<label class=" form-control-label">Codigo de Sistema :</label>
				</div>
				<div class="col-12 col-md-9">
					<span  class="badge badge-secondary"><?php echo $codigo; ?></span>
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Nombre :</label></div>
				<div class="col-12 col-md-9">
					<input type="text" id="nombre" maxlength="200" name="nombre" placeholder="Nombre de modulo" class="form-control" value="<?php echo $nombre; ?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label class=" form-control-label">Nivel :</label></div>
				<div class="col-12 col-md-9">
					<select name="nivel" id="nivel" class="form-control" >
						<option value='-1'>--Seleccionar--</option>
						<?php $sql="select codigo,valor as nombre from sis.catalogo where tipo='TP_ROLES' order by valor";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?> <option <?php if($reg["codigo"]==$nivel) { echo "selected='selected'";}?> 
						 value="<?php echo $reg["codigo"];?>" ><?php echo $reg["nombre"];?> </option> 
						<?php } ?>
					</select>	
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label class=" form-control-label">Mostrar :</label></div>
				<div class="col-12 col-md-9">
					<select name="mostrar" id="mostrar" class="form-control" onchange="mostrar_icono()" >
						<option value='-1'>--Seleccionar--</option>
						<?php $sql="select datos,valor as nombre from sis.catalogo where tipo='TP_ROLES' order by valor";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?> <option <?php if($reg["datos"]==$mostrar) { echo "selected='selected'";}?> 
						 value="<?php echo $reg["datos"];?>" ><?php echo $reg["nombre"]."(".$reg["datos"].")";?> </option> 
						<?php } ?>
					</select>	
				</div>
			</div>
		</div> 
	</div> <!-- /.card -->
	<input type='hidden' name='codigo' id="codigo" value='<?php echo $codigo;?>'>	
</form>