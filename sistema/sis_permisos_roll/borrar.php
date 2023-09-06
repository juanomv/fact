<?php
include("../../valida.php");
require_once("../../conexion.php");
if(ValidaUsuario()==false){echo "Por favor inicie sesion"; return false;}
if (isset($_POST["codigo"]))
{	$sql="delete from modulos where codigo='".$_POST["codigo"]."';";
	$r= pg_query($conn,$sql);
}
//echo "<script type=''> alert('Datos Borrados........  '); <script>";
echo "ok";

?>