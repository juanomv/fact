<?php 
$opcion_win=$_POST["opcion_contenido"];
$evento=$_POST["evento_contenido"];
$item=$_POST["item_contenido"];
//$evento=$_POST["evento_windows"];
//$item=$_POST["item_windows"];

if($evento=='EDIT'){
	$codigo=$item;
	$sql="select * from sis.modulos where codigo='".$codigo."'  ";
	//echo $sql;
	$res=pg_query($conn,$sql);
	//if(pg_num_rows($res)!=0){ 
	if($reg=pg_fetch_array($res)){;
		//$res=mysql_query($sql, $Conn);
		$codigo=$reg["codigo"];
		$pagina=$reg["pagina"];	
		$nombre=utf8_decode($reg["nombre"]);
		$tipo=$reg["tipo"];
		$padre=$reg["padre"];
		$directo=$reg["directo"];
		$dir_img=$reg["dir_img"];
		$orden=$reg["orden"];
		$referencia=$reg["referencia"];
		$varios=$reg["varios"];
		$varios_menu=$reg["varios_menu"];
		$varios_texto=$reg["varios_texto"];
		$varios_color=$reg["varios_color"];
		$varios_logo=$reg["varios_logo"];
		$referencia=$reg["referencia"];
		$varios_padre=$reg["varios_padre"];
		$varios_fila=$reg["varios_fila"];
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
						<h4 ><strong>Registro Modulos <span id="gif_cargando_principal" class="l-btn-icon cargando_mini" style="display:none;" > </span></strong></h4>
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
				<div class="col-12 col-md-3">
					<input type="text" id="nombre" maxlength="200" name="nombre" placeholder="Nombre de modulo" class="form-control" value="<?php echo $nombre; ?>">
				</div>
                <div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">Pagina :</label></div>
				<div class="col-12 col-md-3">
					<input type="text" id="pagina" maxlength="200" name="pagina" placeholder="carpeta modulo" class="form-control" value="<?php echo $pagina; ?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Orden :</label></div>
				<div class="col-12 col-md-3">
					<input type="text" id="orden" maxlength="5" name="orden" placeholder="orden" class="form-control" value="<?php echo $orden; ?>">
				</div>
                <div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">Acceso directo :</label></div>
				<div class="col-12 col-md-3">
					  <input type="checkbox" class="switch-input"  
					  name="directo" id="directo"  style="width:25px; height:25px;"
					  value="1"  <?php if($directo=="1"){echo "checked='checked'";} ?> /> 
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label class=" form-control-label">Tipo modulo :</label></div>
				<div class="col-12 col-md-3">
					<select name="tipo" id="tipo" class="form-control" >
                        <?php $sql="select codigo,valor as nombre from sis.catalogo where tipo='TP_MENU' order by nombre";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>	<option <?php if($reg["codigo"]==$tipo) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["nombre"];?> </option> <?php } ?>
					</select>	
				</div>
				<div class="col-12 col-md-3"><label class=" form-control-label">Menu Padre :</label></div>
				<div class="col-12 col-md-3">
					<select name="padre" id="padre" class="form-control" >
						<option <?php if($padre=="-1"){echo 'selected="selected"';} ?> value="-1">PRINCIPAL</option>
						<?php $sql="select codigo,sis.mi_acendencia(codigo) as nombre from sis.modulos where codigo<>'-1' and tipo='M' and codigo<>'".$codigo."'  order by nombre";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>	<option <?php if($reg["codigo"]==$padre) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["nombre"];?> </option> <?php } ?>
					</select>	
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label class=" form-control-label">Imagen Boton :</label></div>
				<div class="col-12 col-md-7">
					<select name="dir_img" id="dir_img" class="form-control" onchange="mostrar_icono()" >
						<?php 
						for($i=0;$i<count($vertor_icons);$i++ ){
						   	$sel="";
							if($vertor_icons[$i]==$dir_img){$sel="selected='selected'";}
							echo  "<option ".$sel." ><span class='preferencias3'></span>".$vertor_icons[$i]."</option>";
						}
			  			?>
					</select>	
				</div>
				<div class="col-12 col-md-2" id="div_img_icono"><i class="fa <?php echo $dir_img; ?>"></i></div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Referencia :</label></div>
				<div class="col-12 col-md-9">
					<input type="text" id="referencia" maxlength='150' name="referencia" placeholder="Correo" class="form-control" value="<?php echo $referencia; ?>">
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3"><label class=" form-control-label">Varios :</label></div>
				<div class="col-12 col-md-3">
					<select name="varios" id="varios" class="form-control" >
                        <?php $sql="select codigo,valor  from sis.catalogo where tipo='S_N' order by valor";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>	<option <?php if($reg["codigo"]==$varios) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["valor"];?> </option> <?php } ?>
					</select>	
				</div>
				<div class="col-12 col-md-3"><label class=" form-control-label">Menu Varios :</label></div>
				<div class="col-12 col-md-3">
					<select name="varios_menu" id="varios_menu" class="form-control" >
						<?php $sql="select codigo,valor  from sis.catalogo where tipo='S_N' order by valor";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>	<option <?php if($reg["codigo"]==$varios_menu) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["valor"];?> </option> <?php } ?>
					</select>	
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3"><label class=" form-control-label">Varios texto :</label></div>
				<div class="col-12 col-md-3">
					<input type="text" id="varios_texto" maxlength='150' name="varios_texto" placeholder="texto" class="form-control" value="<?php echo $varios_texto; ?>">
				</div>
				<div class="col-12 col-md-3"><label class=" form-control-label">Varios color :</label></div>
				<div class="col-12 col-md-3">
					<input type="text" id="varios_color" maxlength='150' name="varios_color" placeholder="color" class="form-control" value="<?php echo $varios_color; ?>">
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3"><label class=" form-control-label">Varios logo :</label></div>
				<div class="col-12 col-md-3">
					<input type="text" id="varios_logo" maxlength='150' name="varios_logo" placeholder="Logo" class="form-control" value="<?php echo $varios_logo; ?>">
				</div>
				<div class="col-12 col-md-3"><label class=" form-control-label">Varios fila :</label></div>
				<div class="col-12 col-md-3">
					<input type="text" id="varios_fila" maxlength='150' name="varios_fila" placeholder="Fila" class="form-control" value="<?php echo $varios_fila; ?>">
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3"><label class=" form-control-label">Varios padre :</label></div>
				<div class="col-12 col-md-9">
					<select name="varios_padre" id="varios_padre" class="form-control" >
						<option value="-1">No aplica</option>
						<?php $sql="select codigo,sis.mi_acendencia(codigo) as nombre from sis.modulos where codigo<>'-1' and varios_menu='S' and codigo<>'".$codigo."'  order by nombre";
						$res=pg_query($conn,$sql);
						while ($reg=pg_fetch_array($res))
						{ ?>	<option <?php if($reg["codigo"]==$varios_padre) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["nombre"];?> </option> <?php } ?>
					</select>	
				</div>
			</div>
            <div id="div_varios" <?php if($varios=='N'){ echo "style='display:none'"; } ?>  class="col-sm-6 col-lg-3" >
            	<a href="javascript:void(0)" onclick="Muestrac_Contenido_principal('<?php echo $pagina; ?>','<?php echo $referencia; ?>')" >
                    <div class="card text-white <?php echo $varios_color;?>">
                        <div class="card-body">
                            <div class="card-left pt-1 float-left">
                                <h3 class="mb-0 fw-r">
                                    <span class="text-light mt-1 m-0"><?php echo $varios_texto;?></span>
                                </h3>
                            </div><!-- /.card-left -->
                            <div class="card-right float-right text-right">
                                <i class="icon fade-5 icon-lg <?php echo $varios_logo; ?>"></i>
                            </div><!-- /.card-right -->
                        </div>
                    </div>
                  </a>
            </div>
            
		</div> 
	</div> <!-- /.card -->
	<input type='hidden' name='codigo' id="codigo" value='<?php echo $codigo;?>'>	
</form>
