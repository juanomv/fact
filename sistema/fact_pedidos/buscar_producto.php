<?php
//require_once("../../conexion.php");
//consulta todos los empleados
$lista_precio=$_POST["lista_precio"];
$bodega=$_POST["bodega"];
$filtro=$_POST["filtro_busca"];
$noacmitido = array("insert", "into", "delete", "update");
$filtro = str_replace($noacmitido, "", $filtro);

$orden=$_GET["orden"];
if($orden==""){$orden="nombre,codigo_barra";}
$campos[0]="nombre";
$campos[1]="codigo_barra";
$campos[2]="marca";
$campos[3]="modelo";
$nd=get_sesion("_ND_");

if($filtro!=""){$filtro=" and upper(".f_concatena($campos,4).") like upper('%".$filtro."%')";}
?>
<style>
.btn-success:active{background:#CDCDCD;}
</style>
<div class="card-body">
	<div class="table-stats order-table ov-h">
		 <table class="table" id="tabla_detalle" >
			<thead>
				<tr>
					<th>Producto</th>
					<th>Add</th>
				</tr>
			</thead>
			<tbody >
<?PHP 
$sql="select pr.codigo,
pr.codigo_barra,
pr.nombre,
pr.marca,
pr.modelo,
pr.descripcion,
coalesce((SELECT trunc(precio,".$nd.") FROM fact.producto_precio where lista_precio='".$lista_precio."' and empresa=pr.empresa and sucursal=pr.sucursal and producto=pr.codigo),0) as precio_act,
coalesce((SELECT trunc(cantidad,".$nd.") from inv.stock_producto_bodega where empresa=pr.empresa and sucursal=pr.sucursal and periodo=pr.periodo and producto=pr.codigo and bodega='".$bodega."'),0) as stock
from inv.producto pr where pr.empresa='".get_sesion("empresa")."' ".$filtro." order by ".$orden." limit 10; ";	
//echo $sql;
$res=pg_query($conn,$sql);
$i=0;
while ($reg=pg_fetch_array($res))
{ $i++; ?> 
			<tr>
				<td><?php echo utf8_decode($reg['nombre']);?>
					<i id="ico_visto_rpducto<?php echo $i;?>" class="fa fa-check" style=" display:none;"></i>
				</td>
				<td>
						<a id="cmd_busca_prod<?php echo $i;?>" href="javascript:void(0)" onclick="res_busca_producto('<?php echo $reg['codigo'];?>',this.id)" 
						class="btn btn-success btn-sm">Agregar</a>
				</td>
			</tr>
		</tbody>
		<?php } ?>
	</table>
</div>