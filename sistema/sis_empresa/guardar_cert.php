<?php
require_once './vendor/autoload.php';
use GuzzleHttp\Promise\Promise;
function ejecutarPromesa($url,$param){
	$promesai= new Promise(function() use (&$promesai,$url,$param){
			$salida="";
			//require_once("conexion.php");
			//echo get_estado_autorizacion("A");
			if(!$conn){
				//$conn = pg_connect("host=localhost port=5436 dbname=FACTMOVIL user=postgres password=HvSystem.2022DB");	
				require("DB_conec.php");
			}
			if(isset($_FILES['certificado_dir'])){
				$dir_emp=$_POST["dir_emp"];
				$clave=$_POST["clave_cert"];
				$empresa=$_POST["codigo"];
				
				$fecha=date("dmY");
				$hora = getdate(time());
				$nombre =  $_FILES['certificado_dir']['name']; //nombre con el que lo subi� el usuario
				$ultimo_punto=strripos($nombre,".");
				$tipo=substr($nombre,$ultimo_punto,(strlen($nombre) - $ultimo_punto));
				$hora_f= $hora["hours"].$hora["minutes"].$hora["seconds"];
				$nombre_nuevo="certificado".$fecha."-".$hora_f."-".rand(1, 9999);
				$destino = $_SERVER['DOCUMENT_ROOT']."/factmovil/documentos/".$dir_emp."/certificados";
				//$destino_nuevo=$destino."/".$nombre_nuevo.$tipo;
				$destino=$destino."/".$nombre_nuevo.$tipo;
				$temp   = $_FILES['certificado_dir']['tmp_name'];
				if(move_uploaded_file($temp, $destino)){
					//validamos que exista el archivo de certificado en el directorio de la emmpresa
					$certificado=$nombre_nuevo.$tipo;
					if ($almacén_cert = file_get_contents($destino)) {
						if (openssl_pkcs12_read($almacén_cert, $info_cert, $clave)){
							$datos = openssl_x509_parse($info_cert['cert'],0);
							$dia=substr($datos["validTo"],4,2);
							$mes=substr($datos["validTo"],2,2);
							$ano="20".substr($datos["validTo"],0,2);
							$valido_hasta=$dia."/".$mes."/".$ano;
							//echo $valido_hasta;
							
							$fercha_cert=date_create($mes."/".$dia."/".$ano);
							$fercha_act=date_create(date("m/d/Y"));
							$diff=date_diff($fercha_cert,$fercha_act);
							if($diff->format("%R%a")>0){
								$msg="alerta('Firma valida hasta: ".$valido_hasta.", actualmente se encuentra caducado el certificado..!');";
								$salida= "<script>".$msg."</script>";
								$promesai->resolve($salida);
								return $promesai;
							}
							$ambiente="";
							$programa=$_SERVER['DOCUMENT_ROOT']."/factmovil/firmador/sri.jar";
							$dir_raiz=$_SERVER['DOCUMENT_ROOT']."/factmovil/documentos/".$dir_emp;
							$new_clave = shell_exec("java -jar ".$programa." encriptar ".$clave." 3 4 5 6 7 8 9 10 11 12");
							$resultado = shell_exec("java -jar ".$programa." firmar ".$dir_raiz." ".$new_clave." ".$certificado." 5 6 7 8 9 10 11 12");
							if($resultado=="OK"){
								$msg="mensaje('Firma valida, registro actualizado');$('#clave_cert').val('');$('#certificado_dir').val('');
								$('#iconocertificado_dir').removeClass('fa-check');$('#div_grupo_msgcert').show();$('#lbl_cert').html('Certificado valido hasta :".$valido_hasta."');";
								$destino_cert = $_SERVER['DOCUMENT_ROOT']."/factmovil/documentos/".$dir_emp."/certificados/certificado.p12";	
								if(file_exists($destino_cert)){unlink($destino_cert);}
								//copy($destino,$destino_cert);
								if (copy($destino,$destino_cert)) {
								//aqui hay que actualizar los datos de la clave de la firma en la tabla empresa
									$sql="update sis.empresa set dir_certificado='".$valido_hasta."',clave_certificado='".$new_clave."' where codigo='".$empresa."';";
									//echo $sql;
									if($conn){$resUpdate=pg_query($conn,$sql);}
									else{$msg="alerta('No hay conexion a la base de datos..!');";}
								}else{$msg="alerta('Ocurrio un error al copiar el certificado, vuelva a intentarlo..!');";}
							}else{$msg="alerta('Firma invalida. NO se han realizado cambios.".$new_clave." ".str_replace("\n",'',$resultado)." ".$clave."');";}
						}else{$msg="alerta('Archivo de Firma invalido.');";}
					}else{$msg="alerta('Almacen de firmas invalido.');";}
					
				}else{$msg="alerta('Ocurrio un error al cargar el certificado, vuelva a intentarlo..!');";}
				$salida= "<script>".$msg."</script>";
			}else{$salida="<script>alerta('Archvio no fue cargado');</script>";	}
			
			$promesai->resolve($salida);
		});
		return $promesai;
	}
$url="";
$param="";
$resPromesa=ejecutarPromesa($url,$param);
$resPromesa->then(
		function($data){
		 	echo $data;
		}
);

$resPromesa->wait();





?>
