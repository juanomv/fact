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
			<div class="table-stats order-table ov-h">
				<table class="table" >
					<thead>
						<tr>
							<th>Modulo</th>
							<th>Acceso</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$sql="select mo.codigo,sis.mi_acendencia(mo.codigo) as nombre, coalesce((select acceso from sis.modulos_roll where modulo=mo.codigo and roll='".$codigo."'),'0') as acceso from sis.modulos mo where mo.codigo<> '-1' and tipo='I' order by nombre";
						//echo $sql;
						$num_reg=0;
						$res=pg_query( $conn,$sql);
						while ($fila = pg_fetch_array($res)) {$num_reg++;?>
						<tr>
							<td>
								<?php echo utf8_decode($fila["nombre"]); ?>
								<input type='hidden' name='mod<?php echo $fila["codigo"]; ?>' id="mod<?php echo $fila["codigo"]; ?>" value='<?php echo $fila["codigo"]; ?>'>
							</td>
							<td>
							
							  	<input type="checkbox" style="width:25px; height:25px;"   
							  		name="acceso<?php echo $fila["codigo"]; ?>" 
							  		id="acceso<?php echo $fila["codigo"]; ?>"  
							  		value="1"  <?php if($fila["acceso"]=="1"){echo "checked='checked'";} ?>> 
								
							</td>
						</tr>
					<?php }//for($i=1;$i<=20;$i++){ ?>
					</tbody>
				</table>  
			</div>
		</div> 
	</div> <!-- /.card -->
	<input type='hidden' name='codigo' id="codigo" value='<?php echo $codigo;?>'>	
</form>