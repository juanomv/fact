<?php
if(ValidaUsuario()==false){echo "<script type=''> alerta('Por favor inicie sesion');</script>"; return false;}
if($_POST["clavenew"]!=$_POST["claveconfir"]){echo "<script>alerta('Error: las claves son diferentes.!');</script>"; return false;}
if($_POST["clavenew"]==""){echo "<script>alerta('Error: Debe ingresar la nueva clave.!');</script>"; return false;}
if(strlen($_POST["clavenew"])<5){echo "<script>alerta('Error: Debe ingresar una clave con mas de 5 caracteres.!');</script>"; return false;}
unset($campos);
$campos[0]="codigo=".get_sesion("usuario");
$campos[1]="nombre=".get_sesion("correo");
$campos[2]="clavenew=clavenew";
$campos[3]="claveact=claveact";
$sql="select * from ".f_genera_parametros_v("sis.web_reg_usuario_clave",$campos);
$res=pg_query($conn,$sql);
//if(!){echo "Error"; return false;}
$reg=pg_fetch_array($res);
if($reg["res"]=='UPDATE'){$msg="mensaje('Registro actualizado Correctammente');";}
else{$msg="alerta('Error: ".$reg["cod"]."');";}
echo "<script>".$msg."MuestraDatos_contenido();</script>";

?>

