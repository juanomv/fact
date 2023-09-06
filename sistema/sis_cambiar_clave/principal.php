<?php 
$ref_conenido=$_POST["ref_contenido"];
$opcion_win=$_POST["opcion_contenido"];
$evento=$_POST["evento_contenido"];
$item=$_POST["item_contenido"];

?>
<form id="form_windows" name="form_windows">
<input type="hidden" id="opcion_windows" name="opcion_windows" value="<?php echo $opcion_win;?>"/>
<input type="hidden" id="accion_windows" name="accion_windows" value=""/>
<input type="hidden" id="evento_windows" name="evento_windows" value="<?php echo $evento;?>"/>
<input type="hidden" id="item_windows" name="item_windows" value="<?php echo $item;?>"/>
	<div class="card" >
		<div class="card-body" >
			<div class="row form-group" >
				<div class="col col-sm-11" >
					<h4 ><strong>Cambio de cave</span></strong><span id="gif_cargando_contenido" class="l-btn-icon cargando_mini" style="display:none;" > </span></h4>
				</div>
				<div class="col col-sm-1" >
					<a href="javascript:void(0)" onclick="CerrarPrincipal()" type="button" class="close" aria-label="Close" style="float:right;">
					<span aria-hidden="true">&times;</span>
				</div>
			</div>
			<div class="row form-group">
				<div class="col col-sm-2" align="center">
					<a  href="javascript:void(0)" onclick="guardar_clave()" class="btn btn-primary btn-sm btn-block" style="align-content: center;" >Guardar</a>
				</div>
			</div>
		</div>
		<div id="datos_contenido" >	
			
		</div> 
	</div> 
</form>
<script>
		function guardar_clave(){
				if($('#claveconfir').val()!=$('#clavenew').val()){alerta('Claves no coinciden'); return false;}
				if($('#clavenew').val()==''){alerta('Debe ingresa la nueva clave'); return false;}
				if($('#clavenew').val().length<5){alerta('Debe ingresa una clave con mas de 5 Caracteres'); return false;}
				guardar();
			}
		function muestra_calve(obj){
			jQuery('#'+obj).attr('type', function(index, attr) {
			return attr == 'text' ? 'password' : 'text';
		  })
		}
		function fuerza_clave(obj){
				 var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
				 var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
				 var enoughRegex = new RegExp("(?=.{6,}).*", "g");
				 if (false == enoughRegex.test($('#'+obj).val())) {
					 	 $('#'+obj).css('background-color','#FFAEAE');
				 } else if (strongRegex.test($('#'+obj).val())) {
						 $('#'+obj).css('background-color','#CAFFCA');
				 } else if (mediumRegex.test($('#'+obj).val())) {
						 $('#'+obj).css('background-color','#FF9'); //#
				 } else {
						$('#'+obj).css('background-color','#FF9'); 
				 }
				 if($('#claveconfir').val()==$('#clavenew').val()){
					$('#claveconfir').css('background-color','#CAFFCA');
				 }else{
					$('#claveconfir').css('background-color','#FFAEAE');	
				 }
				 if($('#'+obj).val()==''){
					 $('#'+obj).css('background-color','#FFF'); 
					 $('#claveconfir').css('background-color','#FFF'); 	
				 }
			}
		function compara_clave(){
				if($('#claveconfir').val()==$('#clavenew').val()){
					$('#claveconfir').css('background-color','#CAFFCA');
				}else{
					$('#claveconfir').css('background-color','#FFAEAE');	
				}
				if($('#claveconfir').val()==''){$('#claveconfir').css('background-color','#FFF');}
			}
			

</script>


