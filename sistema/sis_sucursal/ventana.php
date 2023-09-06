<?php 
$opcion_win=$_POST["opcion_contenido"];
$evento=$_POST["evento_contenido"];
$item=$_POST["item_contenido"];
//$evento=$_POST["evento_windows"];
//$item=$_POST["item_windows"];

if($evento=='EDIT'){
	$codigo=$item;
	$sql="select * from sis.sucursal where cuenta='".get_sesion("id_cuenta")."' and  empresa='".get_sesion("empresa")."' and codigo='".$codigo."'  ";
	//echo $sql;
	$res=pg_query($conn,$sql);
	//if(pg_num_rows($res)!=0){ 
	if($reg=pg_fetch_array($res)){;
		//$res=mysql_query($sql, $Conn);
		$codigo=$reg["codigo"];
		$nombre=utf8_decode($reg["nombre"]);
		$direccion=utf8_decode($reg["direccion"]);
		$telefono=$reg["telefono"];
		$codigo_fact=$reg["codigo_fact"];
	}
}
$num_incons=0;
unset($vertor_icons);
$fp = fopen("img/iconos_img.css", "r");
	while(!feof($fp)) {
	$linea = fgets($fp);
	$pos = strpos($linea, "{");
		if($pos!=false){	
			$buscar  = array("'", "{", "."," ");
			$reemplazar = array("", "","");
			$resul=str_ireplace($buscar,$reemplazar,$linea);	
			$vertor_icons[$num_incons]=trim($resul);
			$num_incons++;
		}
	}
fclose($fp);
sort($vertor_icons);
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
						<h4 ><strong>Registro de Sucursales <span id="gif_cargando_principal" class="l-btn-icon cargando_mini" style="display:none;" > </span></strong></h4>
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
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Nombre :</label></div>
				<div class="col-12 col-md-9">
					<input type="text" id="nombre" maxlength="200" name="nombre" placeholder="Nombre de sucursal" class="form-control" value="<?php echo $nombre; ?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Direccion :</label></div>
				<div class="col-12 col-md-9">
					<input type="text" id="direccion" maxlength="200" name="direccion" placeholder="Direccion sucursal" class="form-control" value="<?php echo $direccion; ?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Telefono :</label></div>
				<div class="col-12 col-md-9">
					<input type="text" id="telefono" maxlength="30" name="telefono" placeholder="Telefono de sucursal" class="form-control" value="<?php echo $telefono; ?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Codigo Facturacion :</label></div>
				<div class="col-12 col-md-9">
					<input type="text" id="codigo_fact" maxlength='3' name="codigo_fact" placeholder="Codigo facturacion ej. 001" class="form-control" value="<?php echo $codigo_fact; ?>">
				</div>
			</div>
		</div> 
	</div> <!-- /.card -->
	<input type='hidden' name='codigo' id="codigo" value='<?php echo $codigo;?>'>	
</form>
