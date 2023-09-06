<?php
session_start();
//print_r($_POST);
include("conexion.php");

$buscar  = array("'", " insert ", " delete ", " update ", " select "," into ", " or ","'");
$reemplazar = array(" ", " ", " ", " ", " "," "," "," ");
$usuario=f_sin_sql($_POST["txtusuario"]);
$clave=f_sin_sql($_POST["txtclave"]);
$empresa="001";
$sql="select 
		us.*,cta.tipo,cta.plan,cta.usados,cta.fecha_ini,cta.fecha_fin,
  		(select nombre from sis.rol_usuario where codigo=us.rol) as nombre_rol,
		(select nombre from sis.empresa where codigo=us.empresa) as nombre_empresa,
		(select nombre from sis.sucursal where codigo=us.sucursal) as nombre_sucursal,
		(select nombre from fact.caja where codigo=us.caja) as nombre_caja
		from sis.usuario us inner join sis.cuenta cta on us.cuenta=cta.codigo
		where us.estado='1' and validado='SI' and 
		upper(us.correo)= upper('".$usuario."') and 
		upper(us.clave)=upper(md5('".$clave."'))";
//echo $sql;
$res=pg_query($conn,$sql);
if ($reg=pg_fetch_array($res)){ 
	//$reg=pg_fetch_array($res);
	$_SESSION["cuenta"]= "cta".$reg["cuenta"];
	$cta= "cta".$reg["cuenta"];
	$_SESSION[$cta."id_cuenta"]= $reg["cuenta"];
	$_SESSION[$cta."usuario"]= $reg["codigo"];
	$_SESSION[$cta."rol"]= $reg["rol"];
	$_SESSION[$cta."periodo"]= $reg["periodo"];
	$_SESSION[$cta."reset_clave"]= $reg["reset_clave"];
	$_SESSION[$cta."rol_usuario"]= $reg["nombre_rol"];
	$_SESSION[$cta."cuenta"]= $reg["cuenta"];
	$_SESSION[$cta."empresa"]= $reg["empresa"];
	$_SESSION[$cta."dir_emp"]= "cta".$reg["cuenta"]."emp".$reg["empresa"];
	$_SESSION[$cta."nombre_empresa"]= $reg["nombre_empresa"];
	$_SESSION[$cta."ambiente"]= $reg["ambiente"];
	if($reg["ambiente"]=="1"){$_SESSION[$cta."nombre_ambiente"]="PRUEBAS";}
	else{$_SESSION[$cta."nombre_ambiente"]="PRODUCCION";}
	$_SESSION[$cta."correo"]= $reg["correo"];
	$_SESSION[$cta."nombre_persona"]=$reg["nombres"];
	$_SESSION[$cta."sucursal"]= $reg["sucursal"];
	$_SESSION[$cta."nombre_sucursal"]= $reg["nombre_sucursal"];
	$_SESSION[$cta."caja"]= $reg["caja"];
	$_SESSION[$cta."nombre_caja"]= $reg["nombre_caja"];
	$_SESSION[$cta."autenticado"]= "SI";
	//datos de la cuenta del usuario
	$_SESSION[$cta."tipo"]= $reg["tipo"]; //indica el tipo de plan G=gratuito; B=basico, P=PROFESIONAL
	$_SESSION[$cta."nombre_plan"]="GRATUITO";
	if($reg["tipo"]=="B"){$_SESSION[$cta."nombre_plan"]="BASICO";}
	if($reg["tipo"]=="P"){$_SESSION[$cta."nombre_plan"]="PROFESIONAL";}
	$_SESSION[$cta."plan"]= $reg["plan"]; //indica el numero de comprobantes asignados al plan
	$_SESSION[$cta."usados"]= $reg["usados"]; //indica el numero de comprobantes usados en el plan
	$_SESSION[$cta."fecha_ini"]= $reg["fecha_ini"]; //indica la fecha de contratacion del plan actual contratado
	$_SESSION[$cta."fecha_fin"]= $reg["fecha_fin"]; //indica el la fecha de finalizacion del plan actual contratado
	//aqui hay que registrar una auditoria de accesos al sistema.
	
	
	if($reg["reset_clave"]=="SI"){//header ("Location: /factmovil/reset/index.php");
		echo "<script type=''>window.location='reset/index.php'; </script>";
	}
	else{header ("Location: sistema.php");
		echo "<script type=''>window.location='sistema.php'; </script>";
	}
}
else{//header("Location: index.php");;
 //echo "<script type=''>alert('Datos Incorrectos".$emp."');window.location='index.php'; <script>";
}
?>
