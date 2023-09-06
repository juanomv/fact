<?php 
$codigo=$_GET["codigo"];
$lista_precio=$_POST["lista_precio"];
$ind=$_POST["fila_actual"];
$por_desto=$_POST["por_desto"];
if($por_desto==''){$por_desto=0;}
$sql="select pr.*,
coalesce((SELECT precio FROM fact.producto_precio where lista_precio='".$lista_precio."' and empresa=pr.empresa and sucursal=pr.sucursal and producto=pr.codigo),0.00000) as precio_act,
coalesce((select cast(porcentaje as integer) from sis.impuesto_sri where codigo_impuesto='2' AND codigo_adm=pr.aplica_iva and fecha_fin='NULL' and empresa=pr.empresa and tipo_impuesto in('I','A')),0) as por_iva
from inv.producto pr where pr.empresa='".get_sesion("empresa")."' and (pr.codigo='".$codigo."' or pr.codigo_barra='".$codigo."')";	
//echo $sql;
$res=pg_query($conn,$sql);
if($reg=pg_fetch_array($res)){
	$codigo=$reg["codigo"];
	$codigo_barra=$reg["codigo_barra"];
	$desc=utf8_decode($reg["nombre"]);
	$precio=$reg["precio_act"];
	$aplica_iva=$reg["aplica_iva"];
	$por_iva=$reg["por_iva"];
	$desto=$precio * $por_desto /100;
	$val_iva=$precio * $por_iva /100;
	echo "<script type=''>
			asigna_datos_fila('".$codigo_barra."',
			'".$codigo."',
			'".$aplica_iva."',
			'".$por_iva."',
			'".$por_desto."',
			'".$val_iva."',
			'".$desc."',
			'".$precio."',
			'".$desto."');
	</script>";

}
else{echo "<script type=''>mensaje('Codigo NO existe');</script>";	}
?>
