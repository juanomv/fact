<?php
if(ValidaUsuario()==false){echo "Por favor inicie sesion"; return false;}
//consulta todos los empleados
$op_busca=$_POST["op_filtro_busca"];
if($op_busca=='producto'){include('buscar_producto.php');}
if($op_busca=='cliente'){include('buscar_cliente.php');}

?>
			
