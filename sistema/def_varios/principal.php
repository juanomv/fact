<?php 
$ref_conenido=$_POST["ref_contenido"];

?>

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
                </a>
			</div>
		</div>
		
		
	</div>
	<div id="datos_contenido" >	
		
	</div> 
</div> <!-- /.card -->

