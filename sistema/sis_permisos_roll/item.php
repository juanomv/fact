<?php 
require_once("conexion.php");
$evento=$_POST["evento_windows"];
$item=$_POST["item_windows"];
if($evento=='EDIT'){
	$codigo=$item;
	$sql="select * from sis.modulos where grupo='".get_sesion("grupo")."' and codigo='".$codigo."'  ";
	//echo $sql;
	$res=pg_query($conn,$sql);
	//if(pg_num_rows($res)!=0){ 
	if($reg=pg_fetch_array($res)){;
		//$res=mysql_query($sql, $Conn);
		//if($fila = mysql_fetch_array($res, MYSQL_ASSOC)){
				$codigo=$reg["codigo"];
				$pagina=$reg["pagina"];	
				$nombre=$reg["nombre"];
				$tipo=$reg["tipo"];
				$padre=$reg["padre"];
				$directo=$reg["directo"];
				$dir_img=$reg["dir_img"];
				$orden=$reg["orden"];
				$referencia=$reg["referencia"];
	}
}
$num_incons=0;
unset($vertor_icons);
$fp = fopen("img/iconos_modulo.css", "r");
	while(!feof($fp)) {
	$linea = fgets($fp);
	$pos = strpos($linea, "{");
		if($pos!=false){	
			$buscar  = array("'", "{", "."," ");
			$reemplazar = array("", "","");
			$resul=str_ireplace($buscar,$reemplazar,$linea);	
			$vertor_icons[$num_incons]=trim($resul);
			$num_incons++;
		}
	}
fclose($fp);
sort($vertor_icons);

?>


<table width="428" border="0" cellspacing="0" cellpadding="0">
<table width="510"  class="Estilo_tabla" id='tabla'>
  <tr>
	  <td width="159"  align="right">Codigo :</td>
    <td width="60" align="left"><input type="text" disabled="disabled" name="cod" id="cod" size="10" maxlength="60" value="<?php echo $codigo; ?>"  /></td>
	  <td width="94" align="right">&nbsp;</td>
	  <td width="177" align="left">&nbsp;</td>
  </tr>
	<tr>
	  <td  align="right">Nombre :</td>
	  <td colspan="3" align="left" ><input type="text" name="nombre" id="nombre" maxlength="150" size="40" value="<?php echo $nombre; ?>" /> </td>
  </tr>
	<tr>
	  <td  align="right">Directorio :</td>
	  <td colspan="3" align="left" ><input type="text"  name="pagina" id="pagina" maxlength="250" size="40" value="<?php echo $pagina; ?>" /> </td>
  </tr>
  <tr>
	  <td  align="right">Orden :</td>
	  <td colspan="3" align="left" ><input type="text"  name="orden" id="orden" maxlength="250" size="40" value="<?php echo $orden; ?>" /> </td>
  </tr>

  <tr>
	  <td  align="right">Tipo :</td>
	  <td colspan="3" align="left" >
	  	<select name="tipo" id="tipo" style="width:200px" size="1" >
	  		<option <?php if($tipo=="I"){echo 'selected="selected"';} ?> value="I">Item </option> 
			<option <?php if($tipo=="M"){echo 'selected="selected"';} ?> value="M">Menu </option> 
	  	</select>
	  </td>
  </tr>
  <tr>
	  <td  align="right">Padre :</td>
	  <td colspan="3" align="left" >
	  	<select name="padre" id="padre" style="width:240px" size="1" >
	  		<option <?php if($padre=="-1"){echo 'selected="selected"';} ?> value="-1">PRINCIPAL</option>
			<?php $sql="select codigo,sis.mi_acendencia(codigo,grupo) as nombre from sis.modulos where grupo='".get_sesion("grupo")."' and codigo<>'-1' and tipo='M' and codigo<>'".$codigo."' and grupo='".get_sesion("grupo")."' order by nombre";
			$res=pg_query($conn,$sql);
			while ($reg=pg_fetch_array($res))
			{ ?>	<option <?php if($reg["codigo"]==$padre) { echo "selected='selected'";}?> value="<?php echo $reg["codigo"];?>" ><?php echo $reg["nombre"];?> </option> <?php } ?>
	  	</select>
	  </td>
  </tr>
  	<tr>
	  <td align="right">Acceso Directo :</td>
	  <td colspan="3" align="left" >
	  <input  type="checkbox" name="directo" id="directo"  value="1"  <?php if($directo=="1"){echo "checked='checked'";} ?> />
	  <label for="directo"><span></span></label>
	   </td>
  </tr>
	<tr>
	  <td  align="right">Imagen Boton :</td>
	  <td colspan="3" align="left" >
	  <select  name="dir_img" id="dir_img" >
	  <?php 
				$num_icons=count($vertor_icons);
				for($i=0;$i<=$num_icons;$i++ ){
				   	$sel="";
					if($vertor_icons[$i]==$dir_img){$sel="selected='selected'";}
					echo  "<option ".$sel." class='".$vertor_icons[$i]."' style='background-position:right;'>".$vertor_icons[$i]."</option>";
				}
	  ?>
	  </select>
	  </td>
  </tr>
  <tr>
	  <td  align="right">Referencia :</td>
	  <td colspan="3" align="left" ><input type="text"  name="referencia" id="referencia" maxlength="250" size="40" value="<?php echo $referencia; ?>" /> </td>
  </tr>
<tr>
	<td><input name="codigo" id="codigo" type="hidden" value="<?php echo $codigo; ?>" /></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
</table>


