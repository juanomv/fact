<?php 
session_start();
require_once("DB_conec.php");
function randomText($length) { 
	$pattern = "1234567890abcdefghijklmnopqrstuvwxyz"; 
	for($i=0;$i<$length;$i++) { $key .= $pattern[rand(0,35)]; } 
	return $key;
}
$_SESSION["secureKey"] = randomText(6);
date_default_timezone_set("America/Guayaquil");
$dir_sistema="factmovil";
//$conn = "'conectar(dbname=EMP001)'";
//$conn = pg_connect("host=localhost port=5432 dbname=ELECCIONES user=usuarioweb password=UsuarioWeb2015");



function base64_url_encode($input) { return strtr(base64_encode($input),'+/=', '-_,'); }
function base64_url_decode($input) { return base64_decode(strtr($input, '-_,', '+/=')); }
function get_sesion($variable){
	if($variable!="cuenta"){
		$cta=$_SESSION["cuenta"];
		$obj=$cta.$variable;
		return $_SESSION[$obj];
	}else{return $_SESSION["cuenta"];}
}
function set_sesion($variable,$valor){
	if($variable!="cuenta"){
		$cta=$_SESSION["cuenta"];
		$obj=$cta.$variable;
		$_SESSION[$obj]=$valor;
	}else{$_SESSION["cuenta"]=$valor;}
}
function get_estado_autorizacion($dato){
	$resultado="NO REGISTRA";
	switch ($dato) {
		case "A": $resultado="AUTORIZADO"; break;
		case "R": $resultado="RECIBIDO"; break; 
		case "D": $resultado="DEVUELTO"; break;
		case "G": $resultado="GENERADO"; break;
		case "F": $resultado="FIRMADO"; break;
		case "N": $resultado="NO AUTORIZADO"; break;
		case "E": $resultado="ENVIADO"; break;
		case "C": $resultado="ANULADO"; break;
	}
	return $resultado;
}
function ejecuta_query($accion,$sql){
	$resultado="";
	$resultado = shell_exec('java -jar '.$_SESSION["ruta_server"].' '.$accion.' "'.$sql.'"');
	return $resultado;
}
function chao_tilde($entra){
	$traduce=array( 'á'=> '&aacute;' , 'é' => '&eacute;' , 'í' => '&iacute;' , 'ó' => '&oacute;' , 'ú' => '&uacute;' , 'ñ' => '&ntilde;' , 'Ñ˜' => '&Ntilde;' , 'Á' => '&auml;' , 'É' => '&euml;' , 'Í' => '&iuml;' , 'Ó' => '&ouml;' , 'Ú' => '&uuml;');
	$sale=strtr( $entra , $traduce );
	return $sale;
}
function truncateFloat($number, $digitos){  
	$raiz = 10; 
	$multiplicador = pow ($raiz,$digitos); 
	$resultado = ((int)($number * $multiplicador)) / $multiplicador; 
	return number_format($number, $digitos,'.','');
}
function truncar($number, $digitos){
	return number_format($number, $digitos,'.','');
}
function getHora(){ 
	$resul="";$hora = getdate(time());
	if($hora["hours"]<10){$resul="0".$hora["hours"].":";}else{$resul=$hora["hours"].":";}	
	if($hora["minutes"]<10){$resul=$resul."0".$hora["minutes"].":";}else{$resul=$resul.$hora["minutes"].":";}
	if($hora["seconds"]<10){$resul=$resul."0".$hora["seconds"];}else{$resul=$resul.$hora["seconds"];}
	return $resul;
}

function ValidaUsuario(){
	if(get_sesion("autenticado")!="SI"){return false;}	else{return true;}}
function f_concatena($campos){
	$cadena="";
	$coma="";
	for($i=0;$i<count($campos);$i++){
		$cadena=$cadena.$coma.$campos[$i]; $coma=" || ";
	}
	return $cadena;
}
function f_limpia_dir_temp($dir_temp){
	$directorio=opendir($dir_temp);
	$fecha_ayer = date("Y/m/d",strtotime($fecha_actual."- 1 days"));
	$datos=array();
	while ($archivo = readdir($directorio)){
		if(($archivo != '.')&&($archivo != '..')){
			$datos[]=$archivo;
		}
	}
	closedir($directorio);
	for($i=0;$i<count($datos);$i++){
		$archivo=$datos[$i];
		$archivo2 = explode("." , $archivo);
		$fecha = date("Y/m/d",filectime($dir_temp.$archivo));
		if($fecha<$fecha_ayer){	unlink($dir_temp.$archivo);}
	}
}
function f_valida_fecha_formato($fecha){
	if(strlen($fecha)==10){	
		if(!is_numeric(substr($fecha, 0, 2))){return ' Formato Invalido dd';}
		if(!is_numeric(substr($fecha, 3, 2))){return ' Formato Invalido mm';}
		if(!is_numeric(substr($fecha, 6, 4))){return ' Formato Invalido yyyy';}	
		if(substr($fecha, 2, 1)!='/'){return ' Formato Invalido /1';}
		if(substr($fecha, 5, 1)!='/'){return ' Formato Invalido /2';}
		$ndia=intval(substr($fecha, 0, 2));
		if($ndia<1 or $ndia>31){return ' Dias invalidos';}	
		$nmes=intval(substr($fecha, 3, 2));	
		if($nmes<1 or $nmes>12){return ' Mes invalidos';}
		if($nmes==4 or $nmes==6 or $nmes==9 or $nmes==11){if($ndia>30){return ' Dias invalidos x mes';}}
		$nano=intval(substr($fecha, 6, 4));
		if($nmes==2){
			if($ndia>29){return ' Dias invalidos x mes';}
			if($ndia==29 and $nano%4 !=0){return ' Dias invalidos x bisiesto';}
		}
		return '';
	}else{ return strlen($fecha).'Fecha invalida';}
}
function f_validateDateEs($date){ 
	$pattern="/^(0?[1-9]|[12][0-9]|3[01])[\/|-](0?[1-9]|[1][012])[\/|-]((19|20)?[0-9]{2})$/"; 
	if(preg_match($pattern,$date)){
		$values=preg_split("[\/|-]",$date);
		if(checkdate($values[1],$values[0],$values[2]))return true;
	}
	return false;
}
function f_genera_parametros($tabla,$campos,$valores,$n_campos){
	$cadena=$tabla."(";	
	$coma="";
	for($i=0;$i<count($campos);$i++){
		if($campos[$i]==$valores[$i]){
			$cadena=$cadena.$coma."'".utf8_encode(f_sin_sql($_POST[$campos[$i]]))."'";
			$coma=",";
		}elseif($valores[$i]=="sesion►"){
			$cadena=$cadena.$coma."'".utf8_encode(get_sesion($campos[$i]))."'";
			$coma=",";
		}elseif($valores[$i]=="chk"){
			if(isset($_POST[$campos[$i]])){$cadena=$cadena.$coma."'".$_POST[$campos[$i]]."'";}
			else{$cadena=$cadena.$coma."'0'";}$coma=",";}
		else{$cadena=$cadena.$coma."'".$valores[$i]."'";$coma=",";}
	}
	$cadena=$cadena.")";
	return $cadena;
}
function f_genera_parametros_v($tabla,$datos){
	$cadena=$tabla."(";$coma="";
	for($i=0;$i<count($datos);$i++){
		$campos=explode("=",$datos[$i]);
		$campo=$campos[0];
		$valor=$campos[1];
		if($campo==$valor){
			$cadena=$cadena.$coma."'".utf8_encode(f_sin_sql($_POST[$campo]))."'";$coma=",";
		}	
		elseif($valor=="sesion►"){
			$cadena=$cadena.$coma."'".get_sesion($campo)."'";$coma=",";
		}
		elseif($valor=="chk"){
			if(isset($_POST[$campo])){$cadena=$cadena.$coma."'".$_POST[$campo]."'";}
			else{$cadena=$cadena.$coma."'0'";}$coma=",";}
		else{$cadena=$cadena.$coma."'".$valor."'";$coma=",";}
	}
	$cadena=$cadena.")";
	return $cadena;
}
function f_genera_parametros_conid($tabla,$campos,$valores,$n_campos,$id){
	$cadena=$tabla."(";
	$coma="";
	for($i=0;$i<$n_campos;$i++){
		if($campos[$i]==$valores[$i]){$cadena=$cadena.$coma."'".utf8_encode(f_sin_sql($_POST[$campos[$i].$id]))."'";$coma=",";}	
		elseif($valores[$i]=="sesion►"){$cadena=$cadena.$coma."'".get_sesion($campos[$i])."'";$coma=",";}
		elseif($valores[$i]=="chk"){
			if(isset($_POST[$campos[$i]])){$cadena=$cadena.$coma."'".$_POST[$campos[$i].$id]."'";}
			else{$cadena=$cadena.$coma."'0'";}$coma=",";}
		else{$cadena=$cadena.$coma."'".$valores[$i]."'";$coma=",";}
	}
	$cadena=$cadena.")";
	return $cadena;
}
function f_genera_filtro($direc,$codigo,$where,$campo=" codigo "){
	$filtro="";
	if($codigo==""){
		if($direc=="2"){
			$direc="1";
		}
		if($direc=="3"){$direc="1";}
	}
	if($direc=="0"){if($codigo==""){$direc="1";}  
	$filtro= $where." cast(".$campo." as integer)=".$codigo." order by cast(".$campo." as integer) LIMIT 1";}	
	if($direc=="1"){$filtro= " order by cast(".$campo." as integer) LIMIT 1";}
	if($direc=="2"){$filtro= $where." cast(".$campo." as integer)<".$codigo." order by cast(".$campo." as integer) desc LIMIT 1";}
	if($direc=="3"){$filtro= $where." cast(".$campo." as integer)>".$codigo." order by cast(".$campo." as integer)  LIMIT 1";}
	if($direc=="4"){$filtro= " order by cast(".$campo." as integer) desc LIMIT 1";}	
	return $filtro;
}
function f_sin_acento($texto){
	$buscar  = array("á","à","é", "è","í","ì","ó","ò","ú","ù","Á","À","É","È","Í","Ì","Ó","Ò","Ú","Ù");
	$reemplazar = array("a","a","e","e","i","i","o","o","u","u","A","A","E","E","I","I","O","O","U","U");	
	$resul=str_replace($buscar,$reemplazar,$texto);	
	return $resul;
}
function f_sin_sql($texto){
	$buscar  = array("'", " insert ", " delete ", " update ", " select "," into ", " or ","'", " drop ");
	$reemplazar = array(" ", " ", " ", " ", " "," "," "," "," ");
	$resul=str_ireplace($buscar,$reemplazar,$texto);
	return $resul;
}
function f_datos_detalle($texto){
	$buscar  = array("|", ";","&");
	$reemplazar = array("¡", ":", " ");	
	$resul=str_ireplace($buscar,$reemplazar,$texto);
	return $resul;
}
function numeroPaginasPdf($archivoPDF){	
	$stream = fopen($archivoPDF, "r");
	$content = fread ($stream, filesize($archivoPDF));
	if(!$stream || !$content)return 0;
	$count = 0;
	$regex  = "/\/Count\s+(\d+)/";
	$regex2 = "/\/Page\W*(\d+)/";
	$regex3 = "/\/N\s+(\d+)/";
	if(preg_match_all($regex, $content, $matches))	$count = max($matches);	
	return $count[0];
}
function f_valida_cedula($ced){	
	$numero=$ced;
	if(strlen($numero)!=10){return false;}	
	if(!is_numeric($numero)){return false;}	
	$impares=0;	
	$pares=0;
	$ultimo_digito=intval($numero[9]);
	$digito_validador=0;
	$suma_total=0;
	for ($i = 0; $i <= 8; $i++) {
		if(is_int(intval($numero[$i]))==false){return false;}
		if( $i == 0 || $i == 2 || $i== 4 || $i == 6 || $i == 8 ){
			$d=intval($numero[$i]);$d=$d*2;if($d>9){
				$d=$d - 9;
			}
			$impares=$impares + $d;
		}
		else{
			$pares=$pares + intval($numero[$i]);
		}
	}
	$suma_total=$impares + $pares; 
	while ($suma_total > 0) {	$suma_total=$suma_total - 10;}	
	$digito_validador=abs($suma_total); 
	if($digito_validador!=$ultimo_digito){return false;}
	return true;
}

function f_valida_cedula_ruc($ced,$tp){
	$numero=$ced;
	if($tp=='PN'){
		if(strlen($numero)!=13 && strlen($numero)!=10){return false;}
	} 
	if($tp=='PJ'){if(strlen($numero)!=13){return false;}}
	if($tp=='PP'){if(strlen($numero)!=13){return false;}}
	if($tp=='PN'){	$multiplicador="2,1,2,1,2,1,2,1,2"; $veri=10; $divi=10;} 
	if($tp=='PJ'){	$multiplicador="4,3,2,7,6,5,4,3,2"; $veri=10; $divi=11;} 
	if($tp=='PP'){	$multiplicador="3,2,7,6,5,4,3,2,0"; $veri=9; $divi=11;}	
	$multi=$campos=explode(",",$multiplicador); 
	$ultimo_digito=intval($numero[($veri - 1)]); 
	$suma_total=0;
	if(!is_numeric($numero)){return false;}
	for($i=0;$i<($veri-1);$i++){
		$d= intval($numero[$i]) *  intval($multi[$i]); 
		if($tp=='PN'){if($d>9){$d=$d-9;}}
		$suma_total=$suma_total + $d;
	}
	$verificador= $suma_total % $divi;
	if ($verificador!=0){ $verificador=$divi - $verificador;} 
	if($verificador!=$ultimo_digito){return false;}
	return true;
}
function f_valida_objetos($objs){for($i=0;$i<count($objs);$i++){if(isset($_POST[$objs[$i]])==false){return false;}}return true;}
function f_valida_acceso_rol($tabla, $conec){$sql_1="select * from sis_accesos_rol_usuario('".get_sesion("adm_usuario")."','".$tabla."','')";$res_1=pg_query($conec,$sql_1);	$reg_1=pg_fetch_array($res_1);if($reg_1["res"]=='NO'){return false;}return true;}function f_genera_digito_mod_11($clave){$resultado=-1;if(strlen($clave)==48){$vector = str_split($clave);$vector_mul=str_split("765432765432765432765432765432765432765432765432");	$suma=0;for($i=0;$i<count($vector);$i++){$suma=$suma+$vector[$i]*$vector_mul[$i];}$residuo=$suma % 11;$resultado=11 - $residuo;	if($resultado==11){$resultado=0;}		if($resultado==10){$resultado=1;}}return $resultado;}
?>