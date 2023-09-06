<?php 
session_start();
require_once("../conexion.php");
if(ValidaUsuario()==false){
	echo "<script type=''>alert('Acceso no autorizado');window.location='../index.php'; </script>";	
}
if(get_sesion("reset_clave")=="NO"){
	echo "<script type=''>alert('Proceso ya se ejecuto');window.location='../index.php'; </script>";	
}
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reset - Factsis</title>
    <meta name="description" content="Reset -  Factsis">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="../img/logo.png">
    <link href="../img/logo.png" rel="shortcut icon" type="image/png" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
<!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
	<script>
		function registrar(){
			var entro=false;
			if($("#txtclave1").val()==""){
				return false;
			}
			if($("#txtclave2").val()==""){
				return false;
			}
			if($("#txtclave3").val()==""){
				return false;
			}
			if(entro==true){
				$("#msgBotRegistro").html('Faltan campos que ingresar');
				$("#msgBotRegistro").show();
				return false;
			}
			$("#msgBotRegistro").hide();
			$("#divCargando").show();
			$.ajax({ 
					type: 'POST',
					async: true, 
					data: $('#form_registrar').serialize(),
					url: "registrar.php",  
					success: function(data) { 
						$("#divRespuesta").html(data);
						//filtrar_busqueda();
						$("#divCargando").hide();
						//setInterval(function () {validar_obj('form_windows');}, 3000);
					}  
			});
		}
	
	</script>
<style>
.btn {
  background-color: DodgerBlue;
  border: none;
  color: white;
  padding: 12px 16px;
  font-size: 16px;
  cursor: pointer;
}

/* Darker background on mouse-over */
.btn:hover {
  background-color: RoyalBlue;
}
#iconocalvenew {
  cursor: pointer
}
#iconocalveconfir {
  cursor: pointer
}
</style>
</head>
<body class="bg-dark">

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.html">
                        <img class="align-content" src="images/logo_velrod.png" alt="">
                    </a>
                </div>
                <div class="login-form">
                	<?php  ?>
                    <form name="form_registrar" id="form_registrar" method="post" >
                    	<div id="divCargando" class="spinner-border spinner-border-sm" style="display:none;" align="right"></div>
                        <h4>Formulario de Reseteo de clave - Factsis</h4>
                        <p id="msgProceso" align="justify"></p>
                        
                        <div class=" row form-group">
                            <div class="col col-sm-12">
                                <div class="input-group">
                                	<div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                	<input name="txtcorreo" id="txtcorreo" type="text" class="form-control" placeholder="<?php echo get_sesion("correo"); ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class=" row form-group">
                            <div class="col col-sm-12">
                                <div class="input-group">
                                	<div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                	<input name="txtclaveactual" id="txtclaveactual" type="password" class="form-control" placeholder="Calve Actual" required>
                                </div>
                            </div>
                        </div>
                        <div class=" row form-group">
                            <div class="col col-sm-12">
                                <div class="input-group">
                                	<div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                	<input name="txtclavenew" id="txtclavenew" type="password" class="form-control" placeholder="Nueva Clave" required>
                                    <div class="input-group-addon"><i id="iconocalvenew" class="fa fa-eye"></i></div>
                                </div>
                                <span id="msgClaveNew" ></span>
                            </div>
                        </div>
                        
                        <div class=" row form-group">
                            <div class="col col-sm-12">
                                <div class="input-group">
                                	<div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                	<input name="txtclaveconfir" id="txtclaveconfir" type="password"  class="form-control" placeholder="Confirma la Nueva Clave" required>
                                    <div class="input-group-addon"><i id="iconocalveconfir" class="fa fa-eye"></i></div>
                                </div>
                                <span id="msgClaveConfir" ></span>
                            </div>
                        </div>
                        <button id="botonRegistrar" type="button" onClick="registrar()"  class="btn btn-primary btn-flat m-b-30 m-t-30" >Guardar</button>
                        <div id="msgBotRegistro" class="alert alert-danger" role="alert" style="display:none;"></div>
                        <input type="hidden" id="valida" name="valida" value="N" 7>
                    </form>
                    <div id="frm_mensaje"  class="sufee-alert alert with-close alert-primary alert-dismissible fade show" 
					style="position:absolute; top:60px; left:300px; display:none;" >
						<span class="badge badge-pill badge-primary">Mensaje</span>
						<p id="texto_mensaje">Texto del mensaje del sistema</p>
						<a href="javascript:void(0)" onClick="cerrar_mensaje()" type="button" class="close" aria-label="Close">
								<span aria-hidden="true">&times;</span>
						</a>
					</div>
                	</div>
                
            </div>
        </div>
    </div>
    <div id="divRespuesta"></div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>-->
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
  	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script>
    		var ancho_sitio= new Number(window.innerWidth);
	  		//alert(ancho_sitio);
	  		if(ancho_sitio<=780){
	  			//$("#menu_derecho").hide();
	  			//$("#header").css("height", "0px");
	  			$("#frm_mensaje").css("left", "20px");
	  			//es_pc=false;
	  		}	
			function mensaje(txt){
				$("#frm_mensaje").show();
				$('#texto_mensaje').html(txt);
				setTimeout(function() {
					 $("#frm_mensaje").hide();
				}, 1500);
			
			}
			function cerrar_mensaje(){
				$("#frm_mensaje").hide();
			}
			$('#txtclavenew').keyup(function(e) {
				 var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
				 var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
				 var enoughRegex = new RegExp("(?=.{6,}).*", "g");
				 if (false == enoughRegex.test($(this).val())) {
					 	 $('#valida').val('N');
						 $('#msgClaveNew').css('color','red');
						 $('#msgClaveNew').html('Más caracteres.');
				 } else if (strongRegex.test($(this).val())) {
						 $('#valida').val('S');
						 $('#msgClaveNew').css('color','green');
						 $('#msgClaveNew').html('Fuerte!');
				 } else if (mediumRegex.test($(this).val())) {
						 //$('#passstrength').className = 'alert';
						 $('#valida').val('S');
						 $('#msgClaveNew').css('color','orange');
						 $('#msgClaveNew').html('Media!');
				 } else {
						 //$('#passstrength').className = 'error';
						 $('#valida').val('N');
						 $('#msgClaveNew').css('color','red');
						 $('#msgClaveNew').html('Débil!');
				 }
				 $('#msgClaveConfir').html('');
				 return true;
			});
			$('#txtclaveconfir').keyup(function(e) {
				if($(this).val()==$('#txtclavenew').val()){
					$('#msgClaveConfir').css('color','green');
					$('#msgClaveConfir').html('Ok!');
				}else{
					$('#msgClaveConfir').css('color','red');
					$('#msgClaveConfir').html('Diferentes!');
				}
			})
			jQuery('#iconocalvenew').on('click', function() {
			  jQuery('#txtclavenew').attr('type', function(index, attr) {
				return attr == 'text' ? 'password' : 'text';
			  })
			})
			jQuery('#iconocalveconfir').on('click', function() {
			  jQuery('#txtclaveconfir').attr('type', function(index, attr) {
				return attr == 'text' ? 'password' : 'text';
			  })
			})
			
			
    </script>

</body>
</html>
