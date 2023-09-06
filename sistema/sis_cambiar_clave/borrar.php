<?php
require_once("../../valida.php");
require_once("../../conexion.php");
if(ValidaUsuario()==false){echo "<script type=''> alert('Por favor inicie sesion');	window.location='../vacio.php';</script>"; return false;}
$codigo=$_GET["codigo"];
$row=0;
if ($codigo<>"") //actualizar registro
{	$sql="delete from usuario where codigo='".$_GET["codigo"]."';";
	if(!$res= pg_query($conn,$sql)){return false;}
	$row=pg_affected_rows($res);
}
//echo "<script type=''> alert('Datos Borrados........  '); <script>";
echo "ok".$row;

?>