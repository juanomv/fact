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
	$sql="SELECT * from fact.caja where empresa='".get_sesion("empresa")."' and  cuenta='".get_sesion("id_cuenta")."' and codigo='".$codigo."' ";
	//echo $sql;
	$res=pg_query($conn,$sql);
	//if(pg_num_rows($res)!=0){ 
	if($reg=pg_fetch_array($res)){;
		//$res=mysql_query($sql, $Conn);
		$codigo=$reg["codigo"];
		$nombre=$reg["nombre"];
		$punto_emision=$reg["punto_emision"];
		$seq_factura=$reg["sec_inicial"];
		$seq_nota_cred=$reg["sec_inicial_nc"];
		$seq_nota_deb=$reg["sec_inicial_nd"];
		$seq_guia=$reg["sec_inicial_gui"];
		$seq_rete=$reg["sec_inicial_ret"];
	}
}

?>
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
                	<input type="text" id="nombre" maxlength="150" name="nombre" placeholder="Nombre de caja" class="form-control" value="<?php echo $nombre; ?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Punto emision :</label></div>
				<div class="col-12 col-md-3">
					<input type="text" id="punto_emision" maxlength="200" name="punto_emision" placeholder="Punto de emision" 
					class="form-control" value="<?php echo $punto_emision; ?>">
				</div>
				<div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">Secuencial factura :</label></div>
				<div class="col-12 col-md-3">
					<input type="text" id="seq_factura" maxlength="9" name="seq_factura" placeholder="Secuenal de facturas" 
					class="form-control" value="<?php echo $seq_factura; ?>">
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Secuencial Nota Cred :</label></div>
				<div class="col-12 col-md-3">
					<input type="text" id="seq_nota_cred" maxlength="9" name="seq_nota_cred" placeholder="Secuenal de Nota de credito" 
					class="form-control" value="<?php echo $seq_nota_cred; ?>">
				</div>
				<div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">Secuencial Nota Deb :</label></div>
				<div class="col-12 col-md-3">
					<input type="text" id="seq_nota_deb" maxlength="9" name="seq_nota_deb" placeholder="Secuenal de Nota de Debito" 
					class="form-control" value="<?php echo $seq_nota_cred; ?>">
				</div>
			</div>
            <div class="row form-group">
				<div class="col col-md-3"><label for="text-input" class=" form-control-label">Secuencial Guia:</label></div>
				<div class="col-12 col-md-3">
					<input type="text" id="seq_guia" maxlength="9" name="seq_guia" placeholder="Secuenal de Guia de remision" 
					class="form-control" value="<?php echo $seq_guia; ?>">
				</div>
				<div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">Secuencial Guia:</label></div>
				<div class="col-12 col-md-3">
					<input type="text" id="seq_rete" maxlength="9" name="seq_rete" placeholder="Secuenal de Retencion" 
					class="form-control" value="<?php echo $seq_rete; ?>">
				</div>
			</div>
		</div> 
	</div> <!-- /.card -->
	<input type='hidden' name='codigo' id="codigo" value='<?php echo $codigo;?>'>	
</form>