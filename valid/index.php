<?php
require_once("../funciones.php");
require_once("../conexion.php");
if(isset($_GET["id"])){
	$textoid =$_GET["id"];
	$data=explode("l",$textoid);
	$clave=$data[0];
	$codigo=$data[1];
	$sql="select * from sis.usuario where clave='".$clave."' and validado='NO' and codigo='".$codigo."'";
	$res=pg_query($conn,$sql);
	if ($reg=pg_fetch_array($res)){ 
		$password_temp=genera_clave();
		$correo_cliente= $reg["correo"];
		$nombreDestino= $reg["nombres"];
		$asunto="Acceso al sistema Factsis";
		$body="Saludos.<br><p>Su cuenta en el Sistema de Facturación Electrónica FactSis se habilito correctamente<br><br>
		Accede al sistema mediante el sigueinte link link: https://factmovil.vrs.com.ec/factmovil/<br><br>
		Usuario: ".$correo_cliente."<br>
		Clave: ".$password_temp."</p>";
		$campos[0]="usuario=".$codigo;
		$campos[1]="tipo=WEB";
    	$campos[2]="clave=".$password_temp;
		$sql="select * from ".f_genera_parametros_v("sis.web_crea_perfil",$campos);
		$res2=pg_query($conn,$sql);
		$reg2=pg_fetch_array($res2);
		if($reg2["res"]=='OK'){
			$respuestaEmail=enviaMail($asunto,$correo_cliente,$nombreDestino,$body);
			echo "<script type=''>alert('Cuenta activada, revise su correo.. le llegaran las credenciales de acceso');window.location='../index.php'; </script>";
		}else{
			echo "<script type=''>alert('Ocurrio un error: ".$reg2["cod"]."');window.location='../index.php'; </script>";
		}
		
	
	}else{header ("Location: ../index.php");}
	//echo "Calve=".$clave."<br>codigo=".$codigo;
}else{
	header ("Location: ../index.php");
	
}

?>