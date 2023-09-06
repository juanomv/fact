<?php
require_once("../../valida.php");
require_once("../../conexion.php");
if(ValidaUsuario()==false){echo "<script type=''> alert('Por favor inicie sesion');	window.location='../vacio.php';</script>"; return false;}
$carpeta="nombramientos";
?>
<html>
<head>
<title>

</title>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.6.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker-es.js"></script>
<script language="JavaScript" type="text/javascript" src="../../js/ajax.js"></script>	
<script language="JavaScript" type="text/javascript" src="../../js/jquery.form.js"></script>
<script language="JavaScript" type="text/javascript" src="../../js/funciones.js"></script>
<script language="JavaScript" type="text/javascript" src="../../js/ajax.js"></script>	
<link href="../../css/HVestilo.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
    	
	function mostrar(id){
		document.getElementById("principal").style.visibility="visible";
		MostrarConsulta('consulta.php?codigo=' + id + '&persona=','datos' );
		document.getElementById("frm").style.visibility="visible";
	}
	
	function ocultar(){
		document.getElementById("principal").style.visibility="hidden";
		document.getElementById("frm").style.visibility="hidden";
	}
	function validar()
		{   var clave1=document.getElementById("clave").value;
			var clave2=document.getElementById("clave2").value;
  			if (clave1!= clave2) {
     			alert("Las claves no son iguales");
     			return false;
  				}
		
  		}
	function guardar_u(idFormulario){
		if(validar()!=false)
			{ $.ajax ({
					type: 'POST',
					async: false,
					data: $('#form').serialize(),
					url: 'guardar.php',
					success: function(data){
						if(data!="ok"){ alert(data); }
						else{alert("Datos registrados correctamente.");}
						window.location.reload();
					}
				});
			}
	}
</script>

<style type="text/css">
<!--
-->
</style>
</head>
<body style="overflow:auto;">
<div id="principal"  class="fondoTransparente"  > 
</div>
<table width="697" align="left">

<tr>
<td valign="top" align="left" colspan="5">
  <span class="Estilo_titulo_ventana_datos">USUARIOS</span>

  </td>
</tr>

<tr class="encabezado">
  <td height="42" align="center" valign="top">&nbsp;</td>
  <td valign="top" align="center">&nbsp;</td>
  <td colspan="2" align="center" valign="top">
  <a href="javascript:void(0)" title="Ingresar"  onClick="mostrar('','');">
  <img src="../../ima/mas.png" width="48" height="48" border="0"></a>
  </td>
</tr>
<tr class="encabezado">
<td valign="top" align="center" width="323">PERSONA</td>
<td valign="top" align="center" width="291">USUARIO</td>
<td valign="top" align="center" width="30">&nbsp;</td>
<td valign="top" align="center" width="33">&nbsp;</td>
</tr>

<?php
$sql="SELECT codigo,nombre,(select nombre from persona where usuario.persona=codigo ) as persona from usuario order by nombre; ";
$res=pg_query($conn,$sql);
while ($reg=pg_fetch_array($res))
{
?>
<tr class="registros">
	<td class="registros" valign="top" align="center" width="323"> <div align="left"><?php echo $reg["persona"]; ?> </div></td>
	<td valign="top" align="center" width="291"> <div align="left"><?php echo $reg["nombre"]; ?> </div></td>
	<td valign="top" align="center" width="30">
	<a href="javascript:void(0)" title="Editar"  onClick="mostrar('<?php echo $reg["codigo"];?>','');">
	<img src="../../ima/editar.png" width="16" height="16" border="0"></a></td>
	<td valign="top" align="center" width="33">
	<a href="javascript:void(0)" title="Eliminar" onClick="eliminar('<?php echo $reg["codigo"];?>')">
	<img src="../../ima/eliminar.png" width="16" height="16" border="0"></a>
	</td>
</tr>
<?php
}
?>
<tr>
<td valign="top" align="right" colspan="5">&nbsp;</td>
</tr>
</table>
<form  action='guardar.php'  method='post' name='form' id="form">
<div id="frm" class="center">
	<div id="encabezad" >
		<table class='tableestilo'>
			<tr>
				<td width="40" align='left'>
					<a href='javascript:void(0)' title='Guardar' onClick="guardar_u('form')">
					<img src='../../ima/guardar.png' width='36' height='33'  border='0'></a>				</td>
				<td width='365' align='right'>&nbsp;</td>
				<td width='67' align='right'>
				<a href='javascript:void(0)' title='Cerrar' onClick='ocultar()'>
				<img src='../../ima/boton_cerrar.gif' width='64' height='13'  border='0'></a>				</td>
			</tr>
		</table>
	</div>
	<div id="datos" >	</div> 
</div>
</form>
</body>
</html>