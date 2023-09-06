<?php 
session_start();
require "../capcha/1-captcha.php";
if(isset($_SESSION["inicio_registro"])){
	if($_SESSION["inicio_registro"]>100){
		echo "<script>alert('Muchos Intentos')</script> ";
		return false;
	}
	$_SESSION["inicio_registro"]++;
	
}else{	$_SESSION["inicio_registro"]=1;}

?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ela Admin - HTML5 Admin Template</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
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
		function refres_captcha(){
			entro=false;
			if($("#txtcorreo").val()==""){
				entro=true;
			}
			if($("#captcha").val()==""){
				entro=true;
			}
			if(entro==true){
				$("#msgBotRegistro").html('Faltan campos que ingresar');
				$("#msgBotRegistro").show();
				return false;
			}
			$("#divCargando").show();
			$.ajax({ 
					type: 'POST',
					async: true, 
					data: $('#form_registrar').serialize(),
					url: "refres_captcha.php",  
					success: function(data) { 
						$("#divRespuesta").html(data);
						//filtrar_busqueda();
						$("#divCargando").hide();
						//setInterval(function () {validar_obj('form_windows');}, 3000);
					}  
			});
		}
		function clear_form(){
			$("#txtcorreo").val("");
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
                        <p id="msgProceso" align="justify"></p>
                        <div class=" row form-group">
                            <div class="col col-sm-12">
                            	<div class="input-group">
                           			<div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                            		<input name="txtcorreo" id="txtcorreo" type="email" class="form-control" placeholder="Email" required>
                                    <div class="input-group-addon"><i id="iconoMsgMail" class="fa "></i></div>
                            	</div>
                            </div>
                           <!-- <div class="col col-sm-1"> <i id="iconoMsgMail" class="fa " style="font-size:28px;"></i></div>-->
                        </div>
                        <p id="pMensajeCorreo"></p>
                        <div id="divCaptcha" class="form-group" align="center" >
                         <?php
						  $PHPCAP->prime();
						  $PHPCAP->draw();
						  ?>
                         </div>
                         <div class="form-group" align="center" >
                         	<button type="button" class="btn" onClick="refres_captcha()" style="width:120px;"><i class="fa fa-refresh"></i> Refres</button>
                         </div> 
                          <div class="form-group">
                            <input name="captcha" id="captcha" type="text" class="form-control" placeholder="Captcha" required>
                            <p id="msgCaptcha" style="color:#FF0000;"></p>
                          </div>
                        <button id="botonRegistrar" type="button" onClick="registrar()"  class="btn btn-primary btn-flat m-b-30 m-t-30"  >Registrar</button>
                        <div id="msgBotRegistro" class="alert alert-danger" role="alert" style="display:none;"></div>
                        <div class="register-link m-t-15 text-center">
                        	<p>Ya tienes cuenta.. ? <a href="../index.php">Inicio</a></p>
                        </div>
                        <input type="hidden" id="auto" name="auto" value="N" 7>
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
    </script>

</body>
</html>
