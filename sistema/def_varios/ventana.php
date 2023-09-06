<?php 
$opcion_win=$_POST["opcion_contenido"];
$evento=$_POST["evento_contenido"];
$item=$_POST["item_contenido"];

//$evento=$_POST["evento_windows"];
//$item=$_POST["item_windows"];
$estado="1";
$validado="NO";
if($evento=='EDIT'){
	$codigo=$item;
	$sql="SELECT * from sis.usuario where cuenta='".get_sesion("id_cuenta")."' and codigo='".$codigo."' ";
	//echo $sql;
	$res=pg_query($conn,$sql);
	//if(pg_num_rows($res)!=0){ 
	if($reg=pg_fetch_array($res)){;
		//$res=mysql_query($sql, $Conn);
		$codigo=$reg["codigo"];
		$rol=$reg["rol"];
		$correo=$reg["correo"];
		$validado=$reg["validado"];
		$estado=$reg["estado"];
		$cedula=$reg["cedula"];
		$nombres=$reg["nombres"];
		$celular=$reg["celular"];
		$empresa=$reg["empresa"];
		$ambiente=$reg["ambiente"];
		$sucursal=$reg["sucursal"];
		$punto_emision=$reg["punto_emision"];
		$mostrar="NO";
	}
}

?>
<form id="form_windows" name="form_windows">
	<input type="hidden" id="opcion_windows" name="opcion_windows" value="<?php echo $opcion_win;?>"/>
	<input type="hidden" id="accion_windows" name="accion_windows" value=""/>
    <input type="hidden" id="evento_windows" name="evento_windows" value="<?php echo $evento;?>"/>
    <input type="hidden" id="item_windows"  name="item_windows" value="<?php echo $item;?>"/>
	<div class="card" >
		<div class="card-body" style="padding-bottom:2px;">
				<div class="row form-group" >
					<div class="col col-sm-11" >
						<h4 ><strong>Registro De usuarios <span id="gif_cargando_principal" class="l-btn-icon cargando_mini" style="display:none;" > </span></strong></h4>
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
				<div class="col col-md-2">
					<label class=" form-control-label">ID Sistema :</label>
				</div>
				<div class="col col-md-4">
					<span  class="badge badge-secondary"><?php echo $codigo; ?></span>
				</div>
				<div class="col-12 col-md-6">Usuario Activo :
					<input type="checkbox" 
                    style="width:25px; height:25px;"
                    name="estado" id="estado"  value="1" <?php if($estado=="1"){echo "checked='checked'";}?>>
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-2"><label for="text-input" class=" form-control-label">Usuario :</label></div>
				<div class="col-12 col-md-10">
                	<?php if($validado=="NO"){ ?>
					<input type="text" id="correo" maxlength="150" name="correo" placeholder="Nombre de usuario" class="form-control" value="<?php echo $correo; ?>">
                    <?php }else{ ?>
                    <input type="text" id="txtcorreo" maxlength="150" name="txtcorreo" disabled="disabled" class="form-control" value="<?php echo $correo; ?>">
                    <input type="hidden" id="correo" name="correo" value="<?php echo $correo; ?>">
                    <?php } ?>
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-2"><label for="text-input" class=" form-control-label">Nombres :</label></div>
				<div class="col-12 col-md-10">
					<input type="text" id="nombres" maxlength="200" name="nombres" placeholder="Nombre Compreto" 
					class="form-control" value="<?php echo utf8_decode($nombres); ?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-2"><label for="text-input" class=" form-control-label">Cedula :</label></div>
				<div class="col-12 col-md-4">
					<input type="text" id="cedula" maxlength="13" name="cedula" placeholder="Cedula" 
					class="form-control" value="<?php echo utf8_decode($cedula); ?>">
				</div>
				<div class="col-12 col-md-2"><label class=" form-control-label">Celular :</label></div>
				<div class="col-12 col-md-4">
					<input type="text" id="celular" maxlength="13" name="celular" placeholder="Telefono celular" 
					class="form-control" value="<?php echo utf8_decode($celular); ?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-2"><label for="text-input" class=" form-control-label">Rol Usuario :</label></div>
				<div class="col-12 col-md-10">
					<select name="rol" id="rol" class="form-control" size="1"  >
						<option value="-1">-- Seleccione Rol ---</option>
						<?php $sql="select rcodigo,rnombre from sis.web_sel_catalogo('".get_sesion("usuario")."','".get_sesion("rol")."','ROLES','')";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?> <option <?php if($reg["rcodigo"]==$rol) { echo "selected='selected'";}?> 
						 value="<?php echo $reg["rcodigo"];?>" ><?php echo $reg["rnombre"];?> </option> 
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-2"><label class=" form-control-label">Empresa :</label></div>
				<div class="col-12 col-md-10">
					<select name="empresa" id="empresa" class="form-control" size="1" onchange="carga_combo('empresa',new Array('sucursal','punto_emision'))" >
						<option value="-1">-- Seleccione Empresa ---</option>
						<?php $sql="select rcodigo,rnombre from sis.web_sel_catalogo('".get_sesion("usuario")."','".get_sesion("rol")."','EMPRESA','')";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?> <option <?php if($reg["rcodigo"]==$empresa) { echo "selected='selected'";}?> 
						 value="<?php echo $reg["rcodigo"];?>" ><?php echo utf8_decode($reg["rnombre"]);?> </option> 
						<?php } ?>
					</select>	
				</div>
			</div>
			<div class="row form-group">
				<div class="col-12 col-md-2"><label class=" form-control-label">Sucursal :</label></div>
				<div class="col-12 col-md-4">
					<div id="divsucursal">
						<select name="sucursal" id="sucursal" class="form-control" size="1" onchange="carga_combo('sucursal',new Array('punto_emision'))">
							<option value="-1">-- Seleccione Sucursal ---</option>
							<?php $sql="select rcodigo,rnombre from sis.web_sel_catalogo('".get_sesion("usuario")."','".get_sesion("rol")."','SUCURSAL','".$empresa."')";
							$res=pg_query($conn,$sql);
							while ($reg=pg_fetch_array($res))
							{ ?> <option <?php if($reg["rcodigo"]==$sucursal) { echo "selected='selected'";}?> 
							 value="<?php echo $reg["rcodigo"];?>" ><?php echo utf8_decode($reg["rnombre"]);?> </option> 
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-2" ><label class=" form-control-label">Punto emision :</label></div>
				<div class="col-12 col-md-4">
					<div id="divpunto_emision">
						<select name="punto_emision" id="punto_emision" class="form-control" size="1" >
							<option value="-1">-- Seleccione caja ---</option>
							<?php $sql="select rcodigo,rnombre from sis.web_sel_catalogo('".get_sesion("usuario")."','".get_sesion("rol")."','CAJA','".$sucursal."')";
							$res=pg_query($conn,$sql);
							while ($reg=pg_fetch_array($res))
							{ ?> <option <?php if($reg["rcodigo"]==$punto_emision) { echo "selected='selected'";}?> 
							 value="<?php echo $reg["rcodigo"];?>" ><?php echo utf8_decode($reg["rnombre"]);?> </option> 
							<?php } ?>
						</select>
					</div>
				</div>
                
			</div>
		</div> 
	</div> <!-- /.card -->
	<input type='hidden' name='codigo' id="codigo" value='<?php echo $codigo;?>'>	
</form>