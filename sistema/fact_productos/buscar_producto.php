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
$windows_size=$_POST["windows_size"];
$oculta_size="";
$mostra_size='style="display:none;"';
$limite="50";
if(intval($windows_size)<770){
	$oculta_size='style="display:none;"';
	$mostra_size="";
	$limite="15";
}
?>
<style>
.btn-success:active{background:#CDCDCD;}
.encabezado_busca {
		background:#999;
		}
	.registros_busca {
		background:#FFF;
		cursor:default;
		}
	.registros_busca:hover {
		background:#CCCCCC;
		cursor:pointer;
		}
</style>

<div class="card-body">
	<div class="table-stats order-table ov-h">
		 <table class="table" id="tabla_detalle" >
			<thead>
				<tr>
                	<th>#</th>
					<th>Producto</th>
					<th <?php echo  $oculta_size; ?>>Descripcion</th>
                    <th <?php echo  $oculta_size; ?>>codigo de barra</th>
                    <th <?php echo  $mostra_size; ?>>Sel</th>
				</tr>
			</thead>
			<tbody >
<?PHP 

$sql="select pr.codigo,
pr.codigo_barra,
pr.nombre,
pr.descripcion
from inv.producto pr where pr.empresa='".get_sesion("empresa")."' ".$filtro." order by ".$orden." limit ".$limite."; ";	
//echo $sql;
$res=pg_query($conn,$sql);
$i=0;
while ($reg=pg_fetch_array($res))
{ $i++; ?> 
			<tr  class='registros_busca' ondblclick="res_busca_producto('<?php echo $reg['codigo'];?>')" >
				<td><?php echo $i;?></td>
                <td><?php echo utf8_decode($reg['nombre']);?></td>
                <td <?php echo  $oculta_size; ?> ><?php echo utf8_decode($reg['descripcion']);?></td>
                <td <?php echo  $oculta_size; ?> ><?php echo utf8_decode($reg['codigo_barra']);?></td>
                <td <?php echo  $mostra_size; ?>>
                    <a  href="javascript:void(0)" onclick="res_busca_producto('<?php echo $reg['codigo'];?>')" 
                    class="btn btn-success btn-sm">Sel</a>
				</td>
			</tr>
		</tbody>
		<?php } ?>
	</table>
    <?php if($i>=50){echo "Mas...";} ?>
</div>