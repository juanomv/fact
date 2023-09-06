<?php include("./conexion.php"); 

$dir_logo="images/votacion2.png";
if(ValidaUsuario()==false){
	echo "<script type=''>window.location='index.php'; </script>";	
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
    <title>VRS Factmovil</title>
    <meta name="description" content="FactMovil">
    <!--<link rel="apple-touch-icon" href="img/logo.png">
    <link href="img/logo.png" rel="shortcut icon" type="image/png" />-->
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="images/new_logo_ico.png">
    <link rel="shortcut icon" href="images/new_logo_ico.png">
		<!-- 
		<link rel="stylesheet" type="text/css" href="img/iconos_img.css">
	 
		<link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">-->
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">-->
	<!-- 	<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/pe-icon-7-stroke.min.css">
		<link rel="stylesheet" href="css/flag-icon.min.css">
    
		
		<link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">-->
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
   <!-- <link rel="stylesheet" href="css/chartist.min.css">
    <link rel="stylesheet" href="css/jqvmap.min.css">

    <link rel="stylesheet" href="css/weather-icons.css" />
    <link rel="stylesheet" href="css/fullcalendar.min.css" /> -->

	<!--<meta name="description" content="Ela Admin - HTML5 Admin Template"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="img/iconos_img.css">
    <link rel="apple-touch-icon" href="images/logo_ico.png">
    <link rel="shortcut icon" href="images/logo_ico.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <!-- CSS only -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />


		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.0-beta/css/bootstrap-select.min.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


   <style>
	    #weatherWidget .currentDesc {
	        color: #ffffff!important;
	    }
        .traffic-chart {
            min-height: 335px;
        }
        #flotPie1  {
            height: 150px;
        }
        #flotPie1 td {
            padding:3px;
        }
        #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        }
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
             height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{
            height: 160px;
        }
			
		.btn-move :hover {background:#CDCDCD;}
		
		.ocultar_size { display:none;		
		}

    </style>
<script>
	var guardando=false; //variable que idenfica si se esta realizando un proceso de almacenado
	var _ND_=2 ; 
	var aux_guardar=false;
	var es_pc=true;
	function borra_subtitle(obj){
		if(obj!=''){
			$("#"+obj+" li").each(function (index) {
				if($(this).hasClass("subtitle")){
					$(this).remove();
				}
			});
		}
	}
	function Muestrac_Contenido_principal(op,ref,obj){
		//olcultamos el menu principal			
		//$("#left-panel").css("display", "none");
		
		var menu=$("#"+obj).parent().parent().attr("id");
		borra_subtitle(menu);
		
		
		//alert(items);
		if(es_pc==false){
			$("#left-panel").hide();
					
		}
    	$("#opcion_contenido").val(op);
		$("#opcion_contenido_windows").val('');
		$("#accion_contenido").val('principal');
		$("#ref_contenido").val(ref);
		$.ajax({ 
			type: 'POST',
			async: true, 
			data: $('#form_windows_center').serialize(),
			url: "open_contenido.php",  
			success: function(data) { 
				$('#div_seccion_central').html(data);
				$('#div_seccion_central').show();// lo mostramos por si esta oculto
				MuestraDatos_contenido();
				$('#div_principal_windows').html(''); //vaciamos el contenido de windows
				//alert('yata');
			}  
		});
		
		}
	function CerrarPrincipal(){
		$('#div_seccion_central').html('');
		$('#div_seccion_central').hide();
		//$("#left-panel").show();
	}
	function MuestraDatos_contenido(){
		$("#accion_contenido").attr('value','consulta');
		$("#gif_cargando_contenido").show();
		$.ajax({ 
				type: 'POST',
				async: true, 
				data: $('#form_windows_center').serialize(),
				url: "datos_contenido.php",  
				success: function(data) { 
					$('#datos_contenido').html(data);
					//setInterval(function () {validar_obj('form_windows_center');}, 3000);
					$("#gif_cargando_contenido").hide();
				}  
		});
	}
	
	function MuestraForm(op){
		$("#opcion_windows").val(op);
		$("#accion_windows").val('ventana');
		$.ajax({ 
				type: 'POST',
				async: true, 
				data: $('#form_windows_center').serialize(),
				url: "open_windows.php",  
				success: function(data) { 
					$('#div_principal_windows').html(data);
					//MuestraDatos(op);
					//ocultamos el contenido principal
					$('#div_seccion_central').hide();
				}  
		});
	}
	
	function CerrarForm(){
		$('#div_seccion_central').show();
		$('#div_principal_windows').html('');
		
	}
	function nuevo(){
		var op = $("#opcion_contenido").val();
		$("#accion_contenido").val('ventana');
		$("#evento_contenido").val('NEW');
		MuestraForm(op);
	}
	function editar(id){
		var op = $("#opcion_contenido").val();
		$("#accion_contenido").val('ventana');
		$("#evento_contenido").val('EDIT');
		$("#item_contenido").val(id);
		MuestraForm(op);
	}
	function guardar(){
		if(aux_guardar==false){
			//alert(validar_obj_form('form_windows'));
			aux_guardar=true;
			$("#accion_windows").val('guardar');
			$.ajax({ 
					type: 'POST',
					async: true, 
					data: $('#form_windows').serialize() + "&"+$('#form_windows_center').serialize(),
					url: "acciones_windows.php",  
					success: function(data) { 
						$('#sis_resultado').html(data);
						aux_guardar=false;
					}  
			});
		}else{mensaje('Se esta ejecutando un proceso...<br> Espere un momento por favor... ');}
	}
	function filtrar_busqueda(){
		$("#gif_cargando_busqueda").show();
		$("#accion_windows").attr('value','buscar'); 
		//var txt_busca = $('#filtro_busca').attr('value');
		//alert(txt_busca);
		var datos= $('#form_windows_center').serialize() + "&"+$('#form_windows').serialize() + "&"+$('#form_windows_buscar').serialize();
		$.ajax({ 
				type: 'POST',
				async: true, 
				data: datos,
				url: "datos_windows.php",  
				success: function(data) { 
					$('#datos_busqueda').html(data);
					$("#gif_cargando_busqueda").hide();
					//setInterval(function () {validar_obj('form_windows');}, 3000);
				}  
		});
	}
	function BuscaEnter(evt){
		//asignamos el valor de la tecla a keynum
		if ( $("#txt_pagina_act").length ) {
  				// hacer algo aqu si el elemento existe
				$('#txt_pagina_act').attr('value',1);
		}
		if(window.event){// IE
			keynum = evt.keyCode;
		}else{
			keynum = evt.which;
			keychar=evt.keyCode;
			}
		//comprobamos si se encuentra en el rango
		if(keynum==13){
			filtrar();
			}
		}
	function abrir_busqueda(op){
		$("#accion_windows").attr('value','buscar'); 
		$("#op_filtro_busca").attr('value',op);
		$("#gif_cargando_busqueda").show();
		$.ajax({ 
				type: 'POST',
				async: true, 
				data: $('#form_windows_center').serialize() + "&"+$('#form_windows').serialize(),
				url: "datos_windows.php?op="+op,  
				success: function(data) { 
					$('#datos_busqueda').html(data);
					//filtrar_busqueda();
					$("#gif_cargando_busqueda").hide();
					//setInterval(function () {validar_obj('form_windows');}, 3000);
				}  
			});
		}
	function cerrar_busqueda(){
		$("#bot_cerrar_busqueda").click();
	}
	function FiltroEnter(evt){
		//asignamos el valor de la tecla a keynum
		if(window.event){// IE
			keynum = evt.keyCode;
		}else{
			keynum = evt.which;
			keychar=evt.keyCode;
		}
		//comprobamos si se encuentra en el rango
		if(keynum==13){
			filtrar_busqueda();
		}
	} 
	function filtrar_reg(){
		if ( $("#txt_pagina_act").length ) {
  				// hacer algo aqu si el elemento existe
				$('#txt_pagina_act').attr('value',1);
		}
		MuestraDatos_contenido();
	}
	// funciones de paginado
	function  pagina_previa(){
		var pg_act=new Number($("#txt_pagina_act").attr('value'));
		if( pg_act>1){
			pg_act	= pg_act -1;
			$("#txt_pagina_act").val(pg_act);
			filtrar();
			}
		}
	function  pagina_siguiente(){
		var pg_act=new Number($("#txt_pagina_act").attr('value'));
		var pg_total=new Number($("#txt_total_pagina").attr('value'));
		if( pg_act<pg_total){
			pg_act	= pg_act  + 1;
			$("#txt_pagina_act").val(pg_act);
			filtrar();
			}
		}
	function filtrar(){
		MuestraDatos_contenido();
		}
	function pregunta(txt){
		//$.messager.show('Mensaje del Sistema',txt,'info');
		$('#texto_pregunta').html(txt);
		//$('#dlg').dialog('open');
		$("#btn_open_pregunta").click();
		
		}
	function cerrar_pregunta(){
		$("#btn_pregunta_no").click();

		}
	function mensaje(txt){
			var htmlAlert = '<div class="alert alert-success"><h4>Mensaje del sistema</h4><BR><p>'+ txt +'</p></div>';
			$(".alert-message").html(htmlAlert);
			$(".alert-message .alert").fadeIn(200); //.delay(2000).fadeOut(1000, function () { $(this).remove(); });
			setTimeout(function() { 
			 $(".alert-message .alert").fadeOut(1000,function () { $(this).remove(); });
			 //$(".alert-message").html('');
			}, 2000);
		//$.messager.show({title:'Mensaje del Sistema', width: 400, height: 'auto',	msg:txt});
		}
	function alerta(txt){
			var htmlAlert = '<div class="alert alert-danger"><h4>Mensaje del sistema</h4><BR><p>'+ txt +'</p></div>';
			$(".alert-message").html(htmlAlert);
			$(".alert-message .alert").fadeIn(200); //.delay(2000).fadeOut(1000, function () { $(this).remove(); });
			setTimeout(function() { 
			 $(".alert-message .alert").fadeOut(1000,function () { $(this).remove(); });
			 //$(".alert-message").html('');
			}, 2000);
		//$.messager.show({title:'Mensaje del Sistema', width: 400, height: 'auto',	msg:txt});
		}
	function cerrar_mensaje(){
		$("#frm_mensaje").hide();
		}
</script>
<!--FUNCIONES PARA CARGAR COMBOS-->
<script>
	function carga_combo(id,vector){
	 $("#accion_windows").attr('value','selec');
	 //for(i=0;i<vector.length;i++){
	 if(vector.length>0){
			MuestraDatosCombo(id,vector);

		}
	}
	function MuestraDatosCombo(padre,hijo){
		$("#div_cargar").css('visibility','visible');
		var vector = new Array();
		for(i=1;i<hijo.length;i++){vector[i-1]=hijo[i];}
		$.ajax({ 
				type: 'POST',
				async: true, 
				data: $('#form_windows_center').serialize() + "&"+ $('#form_windows').serialize(),
				url: "datos_windows.php?op="+padre+"&hijo="+hijo[0],  
				success: function(data) { 
					$('#div'+hijo[0]).html(data);
					$("#div_cargar").css('visibility','hidden');
					if(vector.length> 0){carga_combo(padre,vector);}
				}
			});
	}
	function auto_select(obj_ori,obj_new){
		$("#"+obj_ori+" select").each(function (index) {
				var val_atc=$(this).val();
				var obj_atc=$(this).attr("id");
				$("#"+obj_new+" select").each(function (index) {
					if($(this).attr("id")==obj_atc){
						$(this).val(val_atc);
					}
				});
				
 		});	
	}
	/// carga combo contenido
	function carga_combo_con(id,vector){
	 $("#accion_contenido").attr('value','selec');
	 //for(i=0;i<vector.length;i++){
	 if(vector.length>0){
			MuestraDatosCombo_con(id,vector);
		}
	}
	function MuestraDatosCombo_con(padre,hijo){
		$("#div_cargar").css('visibility','visible');
		var vector = new Array();
		for(i=1;i<hijo.length;i++){vector[i-1]=hijo[i];}
		$("#padre_combo").val(padre);
		$("#hijo_combo").val(hijo[0]);
		$.ajax({ 
				type: 'POST',
				async: true, 
				data: $('#form_windows_center').serialize(),
				url: "datos_contenido.php",  
				success: function(data) { 
					$('#div'+hijo[0]).html(data);
					$("#div_cargar").css('visibility','hidden');
					if(vector.length> 0){carga_combo_con(padre,vector);}
					else{$("#padre_combo").val("");$("#hijo_combo").val("");filtrar_reg();}
				}
			});
	}
</script>
<!--FUNCIONES PARA CARGAR COMBOS-->		
</head>
<!--<body style=" height: 500px; background-image:url(<?php echo $dir_logo ?>); background-repeat: no-repeat;  background-attachment: fixed;background-position:  center;  background-size: 500px 300px;  ">-->
<body >
    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul id="menu_principal" class="nav navbar-nav">
                	<li class="active">
                        <a href="#"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                    </li>
                    <li id="menu_perfil" class="menu-item-has-children dropdown" style="display:none;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user"></i>Perfil</a>
                        <ul id="menu_ini" class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-user"></i><a href="javascript:void(0)"><?php echo "Usuario: ".get_sesion("nombre_persona"); ?></a></li>
                            <li><i class="fa fa-user"></i><a href="javascript:void(0)"><?php echo "Rol: ".get_sesion("rol_usuario"); ?></a></li>
                            <li><i class="fa fa-user"></i><a href="javascript:void(0)"><?php echo "Plan: ".get_sesion("nombre_plan"); ?></a></li>
                            <li><i class="fa fa-building-o"></i><a href="javascript:void(0)"><?php echo "Empresa: ".get_sesion("nombre_empresa"); ?></a></li>
                            <li><i class="fa fa-building-o"></i><a href="javascript:void(0)"><?php echo "Sucursal: ".get_sesion("nombre_sucursal"); ?></a></li>
                            <li><i class="fa fa-shopping-cart"></i><a href="javascript:void(0)"><?php echo "Caja: ".get_sesion("nombre_caja"); ?></a></li>
                            <li><i class="fa fa-power-off"></i><a href="javascript:void(0)"  onClick="Muestrac_Contenido_principal('sis_salir','Cerrrar sesion')">Cerrar sesion</a></li>
                        </ul>
                    </li>
					<?php $sql="SELECT * from sis.genera_menu_movil('".get_sesion("rol")."','-1','')";
					//echo $sql;
					$res=pg_query($conn,$sql);
					while ($reg=pg_fetch_array($res))
					{ echo $reg["res"]; } 
					?> <!--
					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
						<i  class="fa fa-bars"></i>Components</a>
                        <ul class="sub-menu children dropdown-menu">
							<li> <i class="app_kappfinder" ></i><a href="ui-buttons.html" >Buttons</a>	</li>
                            <li><i class="app_kappfinder"></i><a href="#">Badges</a></li>
                            <li><i class="fa fa-bars"></i><a href="ui-tabs.html">Tabs</a></li>
                            <li><i class="fa fa-exclamation-triangle"></i><a href="ui-alerts.html">Alerts</a></li>
                            <li><i class="fa fa-spinner"></i><a href="ui-progressbar.html">Progress Bars</a></li>
                            <li><i class="fa fa-fire"></i><a href="ui-modals.html">Modals</a></li>
                            <li><i class="fa fa-book"></i><a href="ui-switches.html">Switches</a></li>
                            <li><i class="fa fa-th"></i><a href="ui-grids.html">Grids</a></li>
                            <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Components</a>
                        <ul class="sub-menu children dropdown-menu">                            <li><i class="fa fa-puzzle-piece"></i><a href="ui-buttons.html">Buttons</a></li>
                            <li><i class="fa fa-id-badge"></i><a href="ui-badges.html">Badges</a></li>
                            <li><i class="fa fa-bars"></i><a href="ui-tabs.html">Tabs</a></li>

                            <li><i class="fa fa-id-card-o"></i><a href="ui-cards.html">Cards</a></li>
                            <li><i class="fa fa-exclamation-triangle"></i><a href="ui-alerts.html">Alerts</a></li>
                            <li><i class="fa fa-spinner"></i><a href="ui-progressbar.html">Progress Bars</a></li>
                            <li><i class="fa fa-fire"></i><a href="ui-modals.html">Modals</a></li>
                            <li><i class="fa fa-book"></i><a href="ui-switches.html">Switches</a></li>
                            <li><i class="fa fa-th"></i><a href="ui-grids.html">Grids</a></li>
                            <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li>
                        </ul>
                    </li>-->
                </ul>
            </div><!-- /.navbar-collapse-->
        </nav>
    </aside> 
   
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
		<!-- Header -->
				
        <header id="header" class="header" >
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./"><img src="images/logo_velrod.png" alt="Logo">
                    <span id="gif_cargando_contenido" class="l-btn-icon cargando_mini" style="display:none; float:right;" > </span>
                    </a>
                    <a class="navbar-brand hidden" href="./"><img src="images/logo_velrod.png" alt="Logo"></a>
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
						
            <div class="top-right" id="menu_derecho">
				<div class="header-menu">
						<div class="user-area dropdown float-right">
							<a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img class="user-avatar rounded-circle" src="img/botones/personal.png" alt="User Avatar">
							</a>
							<div id="menu_derecho_datos" class="user-menu dropdown-menu" style="min-width: 350px;">
									<a class="nav-link" href="javascript:void(0)"><i class="fa fa-user"></i><?php echo "Usuario: ".get_sesion("nombre_persona"); ?></a>
                                    <a class="nav-link" href="javascript:void(0)"><i class="fa fa-user"></i><?php echo "Rol: ".get_sesion("rol_usuario"); ?></a>
									<a class="nav-link" href="javascript:void(0)"><i class="fa fa-user"></i><?php echo "Plan : ".get_sesion("nombre_plan"); ?></a>
                                    <a class="nav-link" href="javascript:void(0)"><i class="fa fa-building-o"></i><?php echo "Empresa : " .get_sesion("nombre_empresa"); ?></a>
                                    <a class="nav-link" href="javascript:void(0)"><i class="fa fa-building-o"></i><?php echo "Scursal : ".get_sesion("nombre_sucursal"); ?></a>
                                    <a class="nav-link" href="javascript:void(0)"><i class="fa fa-shopping-cart"></i><?php echo "Caja : ".get_sesion("nombre_caja"); ?></a>
									<!--<a class="nav-link" href="javascript:void(0)" onClick="mensaje('prueba')"><i class="fa fa -cog"></i><span id="tipo_disp" >prueba</span></a>-->
									<a class="nav-link" href="javascript:void(0)" onClick="Muestrac_Contenido_principal('sis_salir','Cerrrar sesion')">
										<i class="fa fa-power-off"></i>Cerrar sesion
									</a>
							</div>
						</div>
				</div>
            </div> 
        </header>
        <!-- /#header -->
        <!-- Content -->
        <div class="content">
					<!-- Animated
					<div class="animated fadeIn">
						<!-- 
						<div class="row">
							<div class="col-md-12 col-lg-4">
								<div class="card">
									<div class="card-body">
										<h4 class="box-title">Chandler</h4>
										<div class="calender-cont widget-calender">
										<div id="calendar"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>  -->
					<form id="form_windows_center" name="form_windows_center">
						<input type="hidden" id="opcion_contenido" name="opcion_contenido" value=""/>
						<input type="hidden" id="opcion_contenido_windows" name="opcion_contenido_windows" value=""/>
						<input type="hidden" id="accion_contenido" name="accion_contenido" value=""/>
						<input type="hidden" id="evento_contenido" name="evento_contenido" value=""/>
						<input type="hidden" id="item_contenido" name="item_contenido" value=""/>
						<input type="hidden" id="ref_contenido" name="ref_contenido" value=""/>
						<input type="hidden" id="padre_combo" name="padre_combo"  />
						<input type="hidden" id="hijo_combo" name="hijo_combo"  />
						<input type="hidden" id="op_filtro_busca" name="op_filtro_busca"  />
                        <input type="hidden" id="windows_size" name="windows_size"  />
						<div id="div_seccion_central" >		
						</div>
						<div id="sis_resultado">
		
						</div>
						
					</form>
					<div id="div_principal_windows" >		
					</div>
					
					<div class="modal fade" id="frm_busqueda" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<form id="form_windows_buscar" name="form_windows_buscar"  >  
									<div class="modal-header">
										<div class="row form-group">
											<div class="col col-sm-8"><h5 class="modal-title" id="smallmodalLabel">Buscador</h5></div>
											<div class="col col-md-2"><span id="gif_cargando_busqueda" class="l-btn-icon cargando_mini" style="display:none;" > </span></div>
											<div class="col col-md-2">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
												</button>
											</div>
										</div>
										<div class="col col-md-12">
											<div class="input-group">
													<div class="input-group-btn">
															<a class="btn btn-primary" href="javascript:void(0)" onClick="filtrar_busqueda()">
																	<i class="fa fa-search"></i> Search
															</a>
													</div>
													<input type="text" id="filtro_busca" name="filtro_busca" placeholder="Buscar" onKeyPress="FiltroEnter(event)" class="form-control">
											</div>
										</div>
									</div>
									<div class="modal-body">
										<div id="datos_busqueda" >	
										</div>
									</div>
									<div class="modal-footer">
										<button id="bot_cerrar_busqueda" type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="modal fade" id="frm_pregunta" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-sm" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="staticModalLabel">Mensaje del Sistema</h5>
								</div>
								<div class="modal-body">
									<p id="texto_pregunta"></p>
								</div>
								<div class="modal-footer">
									<a id="btn_pregunta_no" type="button" class="btn btn-secondary" data-dismiss="modal">No</a>
									<a id="btn_pregunta_si" type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</a>
								</div>
							</div>
						</div>
					</div>
					<button id="btn_open_pregunta" type="button" class="btn btn-danger mb-1"  
					data-toggle="modal" data-target="#frm_pregunta" style="display:none;"></button>
					<div id="frm_mensaje"  class="sufee-alert alert with-close alert-primary alert-dismissible fade show" 
					style="position:absolute; top:60px; left:300px; display:none;" >
						<span class="badge badge-pill badge-primary">Mensaje</span>
						<p id="texto_mensaje">Texto del mensaje del sistema</p>
						<a href="javascript:void(0)" onClick="cerrar_mensaje()" type="button" class="close" aria-label="Close">
								<span aria-hidden="true">&times;</span>
						</a>
					</div>
                    <div class="alert-message" style="position: absolute;bottom: 0;  right:0; min-width:100px; min-height:30px; float:right;"> </div>
                    
                    
					
				</div>
        <!-- /.content -->
        
        <!-- Footer 
        <footer class="site-footer">
            <div class="footer-inner bg-white">
                <div class="row">
                    <div class="col-sm-6">
                        Copyright &copy; 2018 Ela Admin
                    </div>
                    <div class="col-sm-6 text-right">
                        Designed by <a href="https://colorlib.com">Colorlib</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- /.site-footer -->
    </div> 
    <!-- /#right-panel -->
		
    <!-- Scripts 
		<script src="js/jquery.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.matchHeight.min.js"></script>
    <script src="assets/js/main.js"></script>

      Chart js 
    <script src="js/Chart.bundle.min.js"></script>

   Chartist Chart
    <script src="js/chartist.min.js"></script>
    <script src="js/chartist-plugin-legend.min.js"></script>

    <script src="js/jquery.flot.min.js"></script>
    <script src="js/jquery.flot.pie.min.js"></script>
    <script src="js/jquery.flot.spline.min.js"></script>

    <script src="js/jquery.simpleWeather.min.js"></script>
    <script src="assets/js/init/weather-init.js"></script>

    <script src="js/moment.min.js"></script>
    <script src="js/fullcalendar.min.js"></script>
    <script src="assets/js/init/fullcalendar-init.js"></script>-->
	
  	
   

     <!--Scripts--> 
    <!--<script src="js/jquery.js"></script>-->
    <!--<script src="https://code.jquery.com/jquery-1.3.1.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>-->
    <!--<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>-->
    <!--<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="assets/js/main.js"></script>

    <!-- Chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.bundle.min.js"></script>

    <!--Chartist Chart-->
    <script src="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartist-plugin-legend@0.6.2/chartist-plugin-legend.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery.flot@0.8.3/jquery.flot.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-pie@1.0.0/src/jquery.flot.pie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-spline@0.0.1/js/jquery.flot.spline.min.js"></script>
	<!--<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>-->
        <!--<script src="assets/js/init/weather-init.js"></script>-->

    <script src="https://cdn.jsdelivr.net/npm/moment@2.22.2/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>
    <script src="assets/js/init/fullcalendar-init.js"></script>
    <!--Local Stuff-->

    <!--Chartist Chart-->




    <!--Local Stuff-->
    
    
    <script>
	/*$(document).focusin(function(e){
		if(e.target.id!=null){
			if(e.target.id.indexOf("fecha")!=-1){
				$("#"+e.target.id).datepicker({dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, yearRange: '-100:+10'});
				//$("#"+e.target.id).mask("99/99/9999");
				//$("#"+e.target.id).addClass("simple-field-data-mask-selectonfocus");
				$("#"+e.target.id).keypress(function(e) { return solofecha(e) ;});
				if($("#"+e.target.id).val()!=''){$("#"+e.target.id).removeClass("texto_invalido");}
			}
		}
	 })
	.focusout(function(e){
		if(e.target.id!=null){
			if(e.target.id.indexOf("fecha")!=-1){
				$("#"+e.target.id).datepicker({dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, yearRange: '-100:+10'});
				if($("#"+e.target.id).attr('required')=='required'){
					if($("#"+e.target.id).val()==''){$("#"+e.target.id).addClass("texto_invalido");}
				}
			}
		}
	 });*/
	
	
        jQuery(document).ready(function($) {
            "use strict";
			$("form").keypress(function(e) {
					if (e.which == 13) {return false; }	 
			});

            // Pie chart flotPie1
            
            }).on('click','.subtitle', function(e) {
				//alert('Item selected');
				$("#menu_principal ul").each(function (index) {
					//var menu=$(this).attr("id");
					//borra_subtitle(menu);
					//alert('uno');
					var existe_stitle=false;

					$("#"+$(this).attr("id")+" li").each(function (index) {
						if($(this).hasClass("subtitle") && existe_stitle==true ){
							$(this).remove();
						}else{existe_stitle=true;}
					});
				});
				

			}); 
			//menu_principal  
            // Pie chart flotPie1  End
            // cellPaiChart
        //$(".subtitle")
		var ancho_sitio= new Number(window.innerWidth);
		$("#windows_size").val(ancho_sitio);
	  		//alert(ancho_sitio);
		if(ancho_sitio<=780){
			$("#menu_derecho").hide();
			$("#header").css("height", "0px");
			$("#frm_mensaje").css("left", "20px");
			$("#menu_perfil").css("display","block");
			//$("#menu_ini").html($("#menu_derecho_datos").html());
			
			es_pc=false;
		}	
    </script>
</body>
</html>
