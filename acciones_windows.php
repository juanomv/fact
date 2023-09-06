<?php
require_once("conexion.php");
if(ValidaUsuario()==false){echo "<script > mensaje('Por favor inicie sesion');</script>"; return false;}
$opcion=$_POST["opcion_windows"];
$accion=$_POST["accion_windows"];
include('sistema/'.$opcion.'/'.$accion.'.php');

?>