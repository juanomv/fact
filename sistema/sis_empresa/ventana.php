<?php 
$opcion_win=$_POST["opcion_contenido"];
$evento=$_POST["evento_contenido"];
$item=$_POST["item_contenido"];
$ref_conenido=$_POST["ref_contenido"];
//$evento=$_POST["evento_windows"];
//$item=$_POST["item_windows"];
$fecha_certificado="";
if($evento=='EDIT'){
	$codigo=$item;
	$sql="select * from sis.empresa where codigo='".$codigo."' and cuenta=".get_sesion("id_cuenta");
	//echo $sql;
	$res=pg_query($conn,$sql);
	//if(pg_num_rows($res)!=0){ 
	if($reg=pg_fetch_array($res)){;
		//$res=mysql_query($sql, $Conn);
		$codigo=$reg["codigo"];
		$ruc=$reg["ruc"];	
		$nombre=utf8_decode($reg["nombre"]);
		$direccion=utf8_decode($reg["direccion"]);
		$telefono=$reg["telefono"];
		$nombre_comercial=utf8_decode($reg["nombre_comercial"]);
		$fecha_certificado=$reg["dir_certificado"];
		$clave_certificado=$reg["clave_certificado"];
		$obligado_contabilidad=$reg["obligado_contabilidad"];
		$contribuyente_regimen_micro=$reg["contribuyente_regimen_micro"];
		$logo=$reg["logo"];
		$correo_fact=$reg["correo_fact"];
		$dir_emp=get_sesion("cuenta")."emp".$reg["codigo"];
		$micarpeta = $_SERVER['DOCUMENT_ROOT'].'/factmovil/documentos/'.$dir_emp;
		if (!file_exists($micarpeta)) {// se procede a crear el directorio completo
			mkdir($micarpeta, 0777, true);
			//echo $micarpeta;
			mkdir($micarpeta."/autorizados", 0777, true);
			mkdir($micarpeta."/certificados", 0777, true);
			mkdir($micarpeta."/devueltos", 0777, true);
			mkdir($micarpeta."/enviados", 0777, true);
			mkdir($micarpeta."/firmados", 0777, true);
			mkdir($micarpeta."/generados", 0777, true);
			mkdir($micarpeta."/logo", 0777, true);
			mkdir($micarpeta."/no_autorizados", 0777, true);
			mkdir($micarpeta."/temp", 0777, true);
		}
		if (!file_exists($micarpeta."/generados/plantilla_firmada.xml")){
			$dir_plantilla = $_SERVER['DOCUMENT_ROOT'].'/factmovil/clases/plantilla_firmada.xml';
			$dest_plantilla=$micarpeta."/generados/plantilla_firmada.xml";
			copy($dir_plantilla,$dest_plantilla);
		}
	}
}

?>

<form id="form_windows" name="form_windows" enctype="multipart/form-data">
	<input type="hidden" id="opcion_windows" name="opcion_windows" value="<?php echo $opcion_win;?>"/>
	<input type="hidden" id="accion_windows" name="accion_windows" value=""/>
    <input type="hidden" id="evento_windows" name="evento_windows" value="<?php echo $evento;?>"/>
    <input type="hidden" id="item_windows" name="item_windows" value="<?php echo $item;?>"/>
    <input type="hidden" id="dir_emp" name="dir_emp" value="<?php echo $dir_emp;?>"/>
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
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Ruc :</label></div>
				<div class="col-12 col-md-9">
					<input type="text" id="ruc" maxlength="13" name="ruc" placeholder="Ruc de empresa" class="form-control" value="<?php echo $ruc; ?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Nombre :</label></div>
				<div class="col-12 col-md-9">
					<input type="text" id="nombre" maxlength="200" name="nombre" placeholder="Nombre de empresa" class="form-control" value="<?php echo $nombre; ?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Direccion :</label></div>
				<div class="col-12 col-md-9">
					<input type="text" id="direccion" maxlength="300" name="direccion" placeholder="Direccion" class="form-control" value="<?php echo $direccion; ?>">
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Direccion :</label></div>
				<div class="col-12 col-md-9">
					<input type="text" id="telefono" maxlength="100" name="telefono" placeholder="Telefono" class="form-control" value="<?php echo $telefono; ?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Nombre Comercial :</label></div>
				<div class="col-12 col-md-9">
					<input type="text" id="nombre_comercial" maxlength="200" name="nombre_comercial" placeholder="Nombre Comercial" class="form-control" value="<?php echo $nombre_comercial; ?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label class=" form-control-label">Obligacion Contabildiad :</label></div>
				<div class="col-12 col-md-9">
					<select name="obligado_contabilidad" id="obligado_contabilidad" class="form-control" >
						<option value="-1">-- Seleccione --</option> 
                        <?php $sql="select codigo,valor from sis.catalogo where tipo='SI_NO'  order by valor";
                        $res=pg_query($conn,$sql);
                        while ($reg=pg_fetch_array($res))
                        { ?>
                        <option <?php if($reg["codigo"]==$obligado_contabilidad) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["valor"];?></option>
                        <?php } ?>
					</select>	
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3"><label class=" form-control-label">Contribuyente regimen Microempresa :</label></div>
				<div class="col-12 col-md-9">
					<select name="contribuyente_regimen_micro" id="contribuyente_regimen_micro" class="form-control" >
						<option value="-1">-- Seleccione --</option> 
                        <?php $sql="select codigo,valor from sis.catalogo where tipo='SI_NO'  order by valor";
                        $res=pg_query($conn,$sql);
                        while ($reg=pg_fetch_array($res))
                        { ?>
                        <option <?php if($reg["codigo"]==$contribuyente_regimen_micro) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["valor"];?></option>
                        <?php } ?>
					</select>	
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Correo :</label></div>
				<div class="col-12 col-md-9">
					<input type="text" id="correo_fact" maxlength='150' name="correo_fact" placeholder="Correo facturacion" class="form-control" value="<?php echo $correo_fact; ?>">
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Certificado :</label></div>
				<div class="col-12 col-md-9">
                	<div class="input-group">
                    	<input name="clave_cert" id="clave_cert" type="text"  class="form-control" placeholder="Clave certificado" >
                        <input type="file" id="certificado_dir" name="certificado_dir" style="display:none;" onchange="ver_doc_select(this.id,'');" >
                        <div class="input-group-addon"><i id="iconocertificado_dir" class="fa "></i></div>
                        <a href="javascript:void(0)" onclick="$('#certificado_dir').trigger('click');" class="input-group-text" >
							<i class="fa fa-search"></i>
						</a>
                        <a href="javascript:void(0)" onclick="guardar_cert();" class="input-group-text" id="inputGroupFileAddon03">
							<i class="fa fa-save"></i>
                        </a>
                    </div>
                </div>
			</div>
            <div id="div_grupo_msgcert" class="row form-group" style=" <?php if($fecha_certificado!=""){ echo "display:block;"; }else{ echo "display:none;";}?>">
				<div class="col col-md-12"><label id="lbl_cert" for="text-input" class=" form-control-label">Certificado valido hasta : <?php echo $fecha_certificado; ?></label></div>
			</div>
             <div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Logo :</label></div>
				<div class="col-12 col-md-9">
                	<div class="input-group">
                    	<input name="nombre_logo" id="nombre_logo" type="text"  class="form-control" disabled="disabled" placeholder="Logo" >
                        <input type="file" id="logo_emp" name="logo_emp" style="display:none;" onchange="ver_img_select(this.id,'nombre_logo');" >
                        <div class="input-group-addon"><i id="iconologo_emp" class="fa "></i></div>
                        <a href="javascript:void(0)" onclick="$('#logo_emp').trigger('click');" class="input-group-text" >
							<i class="fa fa-search"></i>
						</a>
                        <a href="javascript:void(0)" onclick="guardar_logo();" class="input-group-text" id="inputGroupFileAddon03">
							<i class="fa fa-save"></i>
						</a>
                    </div>
                </div>
			</div>
            
            <div class="row form-group">
				<div class="col col-md-12" id="div_logo">
                	<?php if($logo!=''){?>
					<img src="<?php echo "./documentos/".$dir_emp."/logo/".$logo;?>" class="w-100 shadow-1-strong rounded mb-4" alt="Boat on Calm Water" />
                    <?php }else{?>
                    <img src="https://factmovil.vrs.com.ec/factmovil/img/sin_imagen.jpg" class="w-100 shadow-1-strong rounded mb-4" alt="Boat on Calm Water" />
                    <?php }?>
                </div>
			</div>
		</div> 
	</div> <!-- /.card -->
	<input type='hidden' name='codigo' id="codigo" value='<?php echo $codigo;?>'>	
</form>
