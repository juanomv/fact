<?php 
$codigo=$_POST["codigo"];
$meza=$_POST["caja"];
$tipo="PROF";
$empresa=get_sesion("empresa");
$sucursal=get_sesion("sucursal");
$periodo=get_sesion("periodo");
$ambiente=get_sesion("ambiente");
$sql="UPDATE inv.operacion SET guia_remision='ANULADO' 
		where empresa='".$empresa."' 
		and periodo='".$periodo."' 
		and sucursal='".$sucursal."'
		and ambiente='".$ambiente."'
		and tipo='".$tipo."' 
		and codigo='".$codigo."'";	
$res=pg_query($conn,$sql);
$reg_afectado = pg_affected_rows($res);
echo "
<script type=''>
	$('#guia_remision').val('ANULADO');
	MuestraDatos_contenido();
	mensaje('Proceso realizado correctamente');
	CerrarForm();
</script>
";
?> 

