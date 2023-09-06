<?php 
session_start();
require_once("../conexion.php");
require_once("../funciones.php");

if(ValidaUsuario()==false){
	echo "<script type=''>alert('Acceso no autorizado');window.location='../index.php'; </script>";		
}
//validamos que las claves sean correctas
$clave_act=f_sin_sql($_POST["txtclaveactual"]);
$clave_new=f_sin_sql($_POST["txtclavenew"]);
$clave_confir=f_sin_sql($_POST["txtclaveconfir"]);
if($clave_new!=$clave_confir){
	echo "<script type=''>mensaje('claves diferentes'); </script>";	
	return false;
}
$usuario=get_sesion("usuario");
$correo=get_sesion("correo");

//validamos que la clave sea la correcta
$sql="Select count(*) as existe from sis.usuario where correo='".$correo."' and clave=md5('".$clave_act."') and validado='SI' and estado='1' and codigo='".$usuario."' ;";
$res=pg_query($conn,$sql);
$reg=pg_fetch_array($res);
if($reg["existe"]!=1){
	echo "<script type=''>mensaje('clave incorrecta'); </script>";	
	return false;	
}
//implica que se puede actualizar los datos del usuario
$sql="UPDATE sis.usuario SET clave=md5('".$clave_new."'), reset_clave='NO' where  correo='".$correo."' and clave=md5('".$clave_act."') and validado='SI' and estado='1' and codigo='".$usuario."' ;";
pg_query($conn,$sql);
set_sesion("reset_clave","NO");
echo "<script type=''>alert('Proceso ejecutado correctamente...!');window.location='../index.php'; </script>";	


?>