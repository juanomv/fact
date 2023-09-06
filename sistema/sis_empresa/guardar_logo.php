<?php
$empresa=$_POST["codigo"];//este el codigo que identifica a la empresa
if($empresa==""){
	echo "<script>alerta('Empresa no existe aun.. registrela previo a ingresar la imagen del logo');</script>";
	return false;
}

if(isset($_FILES['logo_emp'])){
	$dir_emp=$_POST["dir_emp"];
	$fecha=date("dmY");
	$hora = getdate(time());
	$nombre =  $_FILES['logo_emp']['name']; //nombre con el que lo subi� el usuario
	$ultimo_punto=strripos($nombre,".");
	$tipo=substr($nombre,$ultimo_punto,(strlen($nombre) - $ultimo_punto));
	$hora_f= $hora["hours"].$hora["minutes"].$hora["seconds"];
	$nombre_nuevo="logo".$fecha."-".$hora_f."-".rand(1, 99999999);
	$destino = $_SERVER['DOCUMENT_ROOT']."/factmovil/documentos/".$dir_emp."/logo";
	//$destino_nuevo=$destino."/".$nombre_nuevo.$tipo;
	$destino=$destino."/".$nombre_nuevo.$tipo;
	$temp   = $_FILES['logo_emp']['tmp_name'];
	if(move_uploaded_file($temp, $destino)){ 
		//ahora actualizamos esta informacion en la base de datos
		$logo=$_POST["logo"];//este registro lo debemos eliminar si existe
		$empresa=$_POST["codigo"];//este el codigo que identifica a la empresa
		$sql="UPDATE sis.empresa set logo='".$nombre_nuevo.$tipo."' where codigo='".$empresa."' ";
		
		pg_query($conn,$sql);
		$destino_old = $_SERVER['DOCUMENT_ROOT']."/factmovil/documentos/".$dir_emp."/logo/".$logo;
		if($logo!=""){
			if(file_exists($destino_old)){unlink($destino_old);}//si existe el anterior archivo se procede a eliminar el logo anterior
		}
		$html='<img src="./documentos/'.$dir_emp.'/logo/'.$nombre_nuevo.$tipo.'" class="w-100 shadow-1-strong rounded mb-4" alt="Boat on Calm Water" />';
		echo "<script>$('#div_logo').html('".$html."'); </script>";
		echo "<script>mensaje('Se almaceno la imagen ".$nombre_nuevo.$tipo."');</script>";
		return false;
	}else{
		echo "<script>alerta('No se almaceno el archivo');</script>";
		return false;
	}
	
}else{echo "<script>alerta('no funco');</script>";	}



?>
