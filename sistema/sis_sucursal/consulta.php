<?php //require_once("../../conexion.php"); 
$windows_size=$_POST["windows_size"];
$txt_filtro=$_POST["txt_buscar"];
unset($campos);
$filtro="";
$residuo=0.4;
$residuo="(0.5-(1/".$_POST["limite_reg"].".00))";
$filtro_mostrar="'ABIERTO'";
///////////
$tipo_filtro="codigo_fact,nombre";
$campos=explode(",",$tipo_filtro);
$filtro="";
if($txt_filtro!=""){$filtro=" and upper(".f_concatena($campos).") like upper('%".$txt_filtro."%')";}

$limite_reg="OFFSET (".$_POST["txt_pagina_act"] ." -1) * (".$_POST["limite_reg"].") limit  ". $_POST["limite_reg"];
//round( (21/10.00)+0.4 ,0) 
$sql="SELECT round((count(*) /  ".$_POST["limite_reg"].".00 ) + ".$residuo.", 0) as total_paginas FROM sis.sucursal 
where cuenta='".get_sesion("id_cuenta")."' and  empresa='".get_sesion("empresa")."' ".$filtro;

//echo $sql;
$res=pg_query( $conn,$sql);
$reg=pg_fetch_array($res);
$total_pg=$reg["total_paginas"];
$oculta_size="";
if(intval($windows_size)<770){
	$oculta_size='class="ocultar_size"';
}
//echo "ancho windows:".$windows_size;
?>
<div class="card-body--">
	<div class="table-stats order-table ov-h" >
		 <table class="table" >
			<thead>
				<tr>
					<th>Codigo</th>
					<th>Nombre</th>
					<th <?php echo  $oculta_size; ?> >Direccion</th>
					<th <?php echo  $oculta_size; ?>>telefono</th>
					<th <?php echo  $oculta_size; ?>>Codigo fact.</th>
					<th >Editar</th>
				</tr>
			</thead>
			<tbody>
					<?php 
						$sql="SELECT * FROM sis.sucursal where cuenta='".get_sesion("id_cuenta")."' and  empresa='".get_sesion("empresa")."' ".$filtro.
						" order by nombre ".$limite_reg;
						//echo $sql;
						$num_reg=0;
						$res=pg_query( $conn,$sql);
						while ($fila = pg_fetch_array($res)) {$num_reg++;?>
						<tr>
							<td><?php echo $fila["codigo"]; ?></td>
							<td><?php echo   utf8_decode($fila["nombre"]); ?></td>
							<td <?php echo  $oculta_size; ?>><?php echo   utf8_decode($fila["direccion"]); ?></td>
							<td <?php echo  $oculta_size; ?>><?php echo   $fila["telefono"]; ?></td>
							<td <?php echo  $oculta_size; ?>><?php echo   $fila["codigo_fact"]; ?></td>
							<td>
								<a  href="javascript:void(0)" onclick="editar('<?php echo $fila["codigo"]; ?>')" class="btn btn-success btn-sm" >Editar</a>
							</td>
						</tr>
					<?php }//for($i=1;$i<=20;$i++){ ?>
				</tbody>
		</table>  
	</div> 
</div>
<script>
		$("#txt_paginas").html(<?php echo "'Pag. ".$_POST["txt_pagina_act"]." de ".$total_pg."'" ; ?>);
		$("#txt_total_pagina").val('<?php echo $total_pg; ?>');
</script>

