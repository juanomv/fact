<?php
require_once("../funciones.php");
require_once("../conexion.php");
if(isset($_GET["id"])){
	$textoid =$_GET["id"];
	$data=explode("l",$textoid);
	$clave=$data[0];
	$codigo=$data[1];
	$dias_validos=10;
	$sql="select tb.*,
	(select nombres from sis.usuario where codigo=tb.usuario ) as nombres
	from sis.usuario_reset tb where tb.clave='".$clave."' and tb.codigo='".$codigo."' and (cast(CURRENT_TIMESTAMP as date) - cast(fecha_reg as date))<".$dias_validos;
	$res=pg_query($conn,$sql);
	if ($reg=pg_fetch_array($res)){ 
		$password_temp=genera_clave();
		$usuario=$reg["usuario"];
		$correo_cliente= $reg["correo"];
		$nombreDestino= $reg["nombres"];
		$asunto="Acceso al sistema Factsis";
		$body="Saludos.<br><p>Su clave fue reseteada correctamente en el Sistema de Facturación Electrónica FactSis<br><br>
		Accede al sistema mediante el sigueinte link : https://factmovil.vrs.com.ec/factmovil/<br><br>
		Usuario: ".$correo_cliente."<br>
		Clave: ".$password_temp."</p>";
		//ahora procedemos a actualizar los datos del usuario con la nueva clave 
		$sql="UPDATE sis.usuario SET clave=md5('".$password_temp."'), reset_clave='SI' where codigo='".$usuario."'";
		pg_query($conn,$sql);
		$respuestaEmail=enviaMail($asunto,$correo_cliente,$nombreDestino,$body);
		echo "<script type=''>alert('Proceso ejecutado correctamente, Revise su correo.. le llegaran las credenciales de acceso');window.location='../index.php'; </script>";
		//ahora anulamos el registro de reseteo de usuario
		$sql="UPDATE sis.usuario_reset SET clave=md5('".$clave."') where clave='".$clave."' and codigo='".$codigo."'";
		pg_query($conn,$sql);
	}else{
		echo "<script type=''>alert('Link invalido');window.location='../index.php'; </script>";
	}
	//echo "Calve=".$clave."<br>codigo=".$codigo;
}else{
	header ("Location: ../index.php");
	
}

?>