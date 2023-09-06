<?php 
$codigo=$_POST["item_busca_windows"];
$sql="select pr.nombre,pr.codigo
from inv.producto pr where pr.cuenta=".get_sesion("id_cuenta")." and  pr.empresa='".get_sesion("empresa")."' and pr.codigo='".$codigo."' ";	
//echo $sql;
$res=pg_query($conn,$sql);
if($reg=pg_fetch_array($res)){
	$codigo=$reg["codigo"];
	$nombre=utf8_decode($reg["nombre"]);
	echo "<script type=''>
		$('#nombre_producto_padre').val('".$nombre."');
		$('#producto_padre').val('".$codigo."');		
	</script>";
}
else{echo "<script type=''>mensaje('Codigo NO existe');</script>";	}
?>
