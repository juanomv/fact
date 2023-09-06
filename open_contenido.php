<?php
require_once("conexion.php");
if(ValidaUsuario()==false){echo "<script > mensaje('Por favor inicie sesion');</script>"; return false;}
$opcion=$_POST["opcion_contenido"];
$accion=$_POST["accion_contenido"];
if($opcion!="sis_salir"){include('sistema/'.$opcion.'/'.$accion.'.php');}
else{include('salir.php');}



?>