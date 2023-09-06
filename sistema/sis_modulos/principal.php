<?php 
$ref_conenido=$_POST["ref_contenido"];

?>
<script type="text/javascript">
	function mostrar_icono(){
		var clase=$("#dir_img").val();
		$("#div_img_icono").html('<i class="fa '+clase+'"></i>');

	}
</script>
<input  type="hidden"  id="limite_reg" name="limite_reg" value="10" />
<input  type="hidden"  id="txt_total_pagina" name="txt_total_pagina" value="1" />
<input  type="hidden"  id="txt_pagina_act" name="txt_pagina_act" value="1" />
<div class="card" >
	<div class="card-body" >
		<div class="row form-group" >
			<div class="col col-sm-11" >
				<h4 ><strong><?php echo $ref_conenido; ?></span></strong></h4>
                
			</div>
			<div class="col col-sm-1" >
				<a href="javascript:void(0)" onclick="CerrarPrincipal()" type="button" class="close" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</div>
		</div>
		<div class="row form-group">
        	<div class="col col-sm-2">
				<a  href="javascript:void(0)" onclick="nuevo()" class="btn btn-success btn-sm " style="align-content: center;" ><i class="fa fa-file-o"></i> Nuevo </a>
			</div>
			<div class="col col-sm-10" align="right">	
				<a  href="javascript:void(0)" onclick="pagina_previa()" class="btn btn-primary btn-sm"  ><</a>
                <span id="txt_paginas" class="badge badge-secondary"  >Pag. 1 de 1</span>
                <a  href="javascript:void(0)" onclick="pagina_siguiente()" class="btn btn-primary btn-sm " >></a>
			</div>
		</div>
		<div class="row form-group">
			<div class="col col-sm-12">
				<div class="input-group">
					<div class="input-group-btn">
							<a class="btn btn-primary" href="javascript:void(0)" onclick="filtrar()">
								<i class="fa fa-search"></i> 
							</a>
					</div>
					<input type="text" id="txt_buscar" name="txt_buscar" placeholder="Texto a Buscar" class="form-control" onKeyPress="BuscaEnter(event)">
				</div>
			</div>
		</div>
	</div>
	<div id="datos_contenido" >	
		
	</div> 
</div> <!-- /.card -->

