<?php

if(ValidaUsuario()==false){echo "<script type=''> alert('Por favor inicie sesion');</script>"; return false;}
$codigo=$_POST["codigo"];
if ($codigo<>"") //actualizar registro
{	$sql="select codigo from sis.modulos where tipo='I' ";
	$res=pg_query($conn,$sql);	
	while($reg=pg_fetch_array($res)){
		unset($campos);
		$campos[0]="usuario=sesion►";
		$campos[1]="codigo=codigo";
    	$campos[2]="mod".$reg["codigo"]."=mod".$reg["codigo"];
		$campos[3]="acceso".$reg["codigo"]."=chk";
		$sql="select * from ".f_genera_parametros_v("sis.web_reg_permiso_roll",$campos);
		//$campos=explode(",","adm_usuario,codigo,mod".$reg["codigo"].",acceso".$reg["codigo"]);
		//$valores=explode(",","secion,codigo,mod".$reg["codigo"].",chk");
		//$sql="select * from ".f_genera_parametros("sis.reg_permiso_roll",$campos,$valores,3);
		//echo $sql."<br>";
		$res2=pg_query($conn,$sql);
		//if(!){echo "Error"; return false;}
	}
}
$msg="Registro actualizado Correctammente";
echo "<script>mensaje('".$msg."');</script>";


?>