<?php
require_once("conexion.php");
if(ValidaUsuario()==false){echo "<script > mensaje('Por favor inicie sesion');</script>"; return false;}
$opcion=$_POST["opcion_contenido"];
$opcion_win=$_POST["opcion_contenido_windows"];
$accion=$_POST["accion_contenido"];
if($opcion_win!=''){include('sistema/'.$opcion_win.'/'.$accion.'.php');}
else{include('sistema/'.$opcion.'/'.$accion.'.php');}



?>