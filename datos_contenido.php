<?php
require_once("conexion.php");
if(ValidaUsuario()==false){echo "<script > mensaje('Por favor inicie sesion');</script>"; return false;}
$opcion=$_POST["opcion_contenido"];
$accion=$_POST["accion_contenido"];
//echo 'sistema-'.$opcion.'-'.$accion;
include('sistema/'.$opcion.'/'.$accion.'.php');

?>