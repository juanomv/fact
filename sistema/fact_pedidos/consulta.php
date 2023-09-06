<?php //require_once("../../conexion.php"); 

$txt_filtro=f_sin_sql($txt_filtro);
unset($campos);
$filtro="";
$residuo=0.4;
$residuo="(0.5-(1/".$_POST["limite_reg"].".00))";
$filtro_mostrar="'ABIERTO'";

$limite_reg="OFFSET (".$_POST["txt_pagina_act"] ." -1) * (".$_POST["limite_reg"].") limit  ". $_POST["limite_reg"];
//round( (21/10.00)+0.4 ,0) 
$sql="SELECT round((count(*) /  ".$_POST["limite_reg"].".00 ) + ".$residuo.", 0) as total_paginas  FROM inv.operacion where ambiente='".get_sesion("ambiente")."' and empresa='".get_sesion("empresa")."' and periodo='".get_sesion("periodo")."' and sucursal='".get_sesion("sucursal")."' and tipo='PROF' and sesion_caja='PROF' and referencia<>'ORDEN' and guia_remision in (".$filtro_mostrar.") ".$filtro;
//echo $sql;
$res=pg_query( $conn,$sql);
$reg=pg_fetch_array($res);
$total_pg=$reg["total_paginas"];


?>
<div class="card-body--">
	<div class="table-stats order-table ov-h">
		 <table class="table" >
			<thead>
				<tr>
					<th>Codigo</th>
					<th>Mesa</th>
					<th>Editar</th>
				</tr>
			</thead>
			<tbody>
					<?php 
						$sql="SELECT 
						codigo,
						fecha,
						secuencial,
						coalesce((SELECT nombre FROM fact.mesa where empresa=op.empresa and codigo=op.caja),'MESA NO REGISTRRADA') as mesa,
						guia_remision
						FROM inv.operacion op where op.ambiente='".get_sesion("ambiente")."' and empresa='".get_sesion("empresa")."' and periodo='".get_sesion("periodo")."' and sucursal='".get_sesion("sucursal")."' and sesion_caja='PROF' and referencia<>'ORDEN' and tipo='PROF' and guia_remision in (".$filtro_mostrar.") ".$filtro." order by cast(secuencial as integer) desc ".$limite_reg;
						//echo $sql;
						$num_reg=0;
						$res=pg_query( $conn,$sql);
						while ($fila = pg_fetch_array($res)) {$num_reg++;
						?>
						<tr>
							<td><?php echo substr($fila["secuencial"],-4); ?></td>
							<td><?php echo utf8_decode($fila["mesa"]); ?></td>
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
				<!-- /.orders -->