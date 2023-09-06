<input  type="hidden"  id="limite_reg" name="limite_reg" value="10" />
<input  type="hidden"  id="txt_total_pagina" name="txt_total_pagina" value="1" />
<input  type="hidden"  id="txt_pagina_act" name="txt_pagina_act" value="1" />
<div class="card" >
	<div class="card-body" >
		<div class="row form-group" >
			<div class="col col-sm-11" >
				<h4 ><strong>Pedidos</span></strong></h4>
				
			</div>
			<div class="col col-sm-1" >
				<a href="javascript:void(0)" onclick="CerrarPrincipal()" type="button" class="close" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</div>
		</div>
		<div class="row form-group">
			<div class="col col-sm-1">	
				<a  href="javascript:void(0)" onclick="pagina_previa()" class="btn btn-primary btn-sm"  ><</a>
			</div>
			<div class="col col-sm-9"  style="text-align:center;"  >	
				<span id="txt_paginas"  class="badge badge-secondary">Pag. 1 de 1</span>
			</div>
			<div class="col col-md-1"><span id="gif_cargando_contenido" class="l-btn-icon cargando_mini" style="display:none;" > </span></div>
			<div class="col col-sm-1">	
				<a  href="javascript:void(0)" onclick="pagina_siguiente()" class="btn btn-primary btn-sm" style="float: right;"  >></a>
			</div>
		</div>
		<div class="row form-group">
			<div class="col col-sm-6">
				<a  href="javascript:void(0)" onclick="nuevo()" class="btn btn-success btn-sm btn-block" style="align-content: center;" >Nuevo Pedido</a>
			</div>
			<div class="col col-sm-6">
				<a  href="javascript:void(0)" onclick="filtrar()" class="btn btn-primary btn-sm btn-block" style="align-content: center;" >Refrescar</a>
			</div>
		</div>
	</div>
	<div id="datos_contenido" >	
		
	</div> 
</div> <!-- /.card -->


