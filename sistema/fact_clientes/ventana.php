<?php 
$opcion_win=$_POST["opcion_contenido"];
$evento=$_POST["evento_contenido"];
$item=$_POST["item_contenido"];
$ref_conenido=$_POST["ref_contenido"];
//$evento=$_POST["evento_windows"];
//$item=$_POST["item_windows"];
$tipo_persona="PN";
$tipo_identificacion="05"; //cedula
$tipo_contribuyente="NO";
if($evento=='EDIT'){
	$codigo=$item;
	$sql="select * from fact.cliente_proveedor where tipo='CLI' and cuenta='".get_sesion("id_cuenta")."' and  empresa='".get_sesion("empresa")."' and codigo='".$codigo."'  ";
	//echo $sql;
	$res=pg_query($conn,$sql);
	//if(pg_num_rows($res)!=0){ 
	if($reg=pg_fetch_array($res)){;
		//$res=mysql_query($sql, $Conn);
		$codigo_cliente=$reg["codigo"];
		$tipo_identificacion=$reg["tipo_identificacion"];
		$cedula=$reg["cedula"];
		$nombre=utf8_decode($reg["nombre"]);
		$direccion=utf8_decode($reg["direccion"]);
		$telefono=$reg["telefono"];
		$email=utf8_decode($reg["email"]);
		$tipo_contribuyente=$reg["tipo_contribuyente"];
		$tipo_persona=$reg["tipo_persona"];
	}
}
$num_incons=0;

?>
<form id="form_windows" name="form_windows">
	<input type="hidden" id="opcion_windows" name="opcion_windows" value="<?php echo $opcion_win;?>"/>
	<input type="hidden" id="accion_windows" name="accion_windows" value=""/>
    <input type="hidden" id="evento_windows" name="evento_windows" value="<?php echo $evento;?>"/>
    <input type="hidden" id="item_windows" name="item_windows" value="<?php echo $item;?>"/>
	<div class="card" >
		<div class="card-body" style="padding-bottom:2px;">
				<div class="row form-group" >
					<div class="col col-sm-11" >
						<h4 ><strong><?php echo $ref_conenido; ?>  <span id="gif_cargando_principal" class="l-btn-icon cargando_mini" style="display:none;" > </span></strong></h4>
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
							<i class="fa fa-save"></i> Guardar
						</a>
					</div>
				</div>
		</div>
		<div class="card-body" style="padding-top: 2px;">
			<div class="row form-group">
				<div class="col col-md-3">
					<label class=" form-control-label">Codigo de Sistema :</label>
				</div>
				<div class="col-12 col-md-9">
					<span  class="badge badge-secondary"><?php echo $codigo; ?></span>
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3">
					<label class=" form-control-label">Tipo Identificacion :</label>
				</div>
				<div class="col-12 col-md-3">
					<select name="tipo_identificacion" id="tipo_identificacion" class="form-control" >
                        <?php $sql="select codigo,valor from sis.catalogo where tipo='TP_IDENT' order by valor";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>	<option <?php if($reg["codigo"]==$tipo_identificacion) { echo "selected='selected'";}?> 
                        value="<?php echo $reg["codigo"];?>" ><?php echo $reg["valor"];?> </option> <?php } ?>
					</select>
				</div>
                <div class="col-12 col-md-3">
					<label class=" form-control-label">Contribuyente Especial:</label>
				</div>
				<div class="col-12 col-md-3">
					<select name="tipo_contribuyente" id="tipo_contribuyente" class="form-control" >
                        <?php $sql="select codigo,valor from sis.catalogo where tipo='SI_NO' order by valor";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>	<option <?php if($reg["codigo"]==$tipo_contribuyente) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["valor"];?> </option> <?php } ?>
					</select>
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3">
					<label class=" form-control-label">Identificacion:</label>
				</div>
				<div class="col-12 col-md-3">
					<input type="text" id="cedula" maxlength="13" name="cedula" placeholder="identificacion" class="form-control" value="<?php echo $cedula; ?>">
				</div>
                <div class="col-12 col-md-3">
					<label class=" form-control-label">Tipo persona :</label>
				</div>
				<div class="col-12 col-md-3">
					<select name="tipo_persona" id="tipo_persona" class="form-control" >
                        <?php $sql="select codigo,valor from sis.catalogo where tipo='TP_PERSONA' order by valor";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>	<option <?php if($reg["codigo"]==$tipo_persona) { echo "selected='selected'";}?> 
                        value="<?php echo $reg["codigo"];?>" ><?php echo $reg["valor"];?> </option> <?php } ?>
					</select>
				</div>
                
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Nombre :</label></div>
				<div class="col-12 col-md-9">
					<input type="text" id="nombre" maxlength="200" name="nombre" placeholder="Nombre de cliente" class="form-control" value="<?php echo $nombre; ?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Correo :</label></div>
				<div class="col-12 col-md-3">
					<input type="email" id="email" maxlength="150" name="email" placeholder="Correo del Cliente" class="form-control" value="<?php echo $email; ?>">
				</div>
                <div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">Telefono :</label></div>
				<div class="col-12 col-md-3">
					<input type="text" id="telefono" maxlength="10" name="telefono" placeholder="Telefono del Cliente" class="form-control" value="<?php echo $telefono; ?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Direccion :</label></div>
				<div class="col-12 col-md-9">
					<input type="text" id="direccion" maxlength="300" name="direccion" placeholder="Direccion del Cliente" class="form-control" value="<?php echo $telefono; ?>">
				</div>
			</div>
			
		</div> 
	</div> <!-- /.card -->
	<input type='hidden' name='codigo' id="codigo" value='<?php echo $codigo;?>'>	
</form>
