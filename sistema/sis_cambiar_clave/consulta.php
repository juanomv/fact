<?php
$opcion=$_POST["opcion_contenido"];
$evento=$_POST["evento_contenido"];
$item=$_POST["item_contenido"];
if(ValidaUsuario()==false){echo "<script type=''> alert('Por favor inicie sesion');</script>"; return false;}
//consulta todos los empleados

//muestra los datos consultados
//onSubmit='return validar()'
$sql="SELECT * FROM sis.usuario where codigo='".get_sesion("usuario")."'";
//echo $sql;
$res=pg_query($conn,$sql);
$codigo="";
$nombre="";
$persona="";
$nom_persona="";
$op="";
if ($reg=pg_fetch_array($res))
{ 		$codigo=$reg["codigo"];
		$correo=$reg["correo"];
		$nom_persona=$reg["nombres"];
}


//echo $sql;	

?>
<div class="card-body" style="padding-top: 2px;">
	<div class="row form-group">
		<div class="col col-md-3">
			<label class=" form-control-label">Persona :</label>
		</div>
		<div class="col-12 col-md-9">
            <input type='text' class="form-control" disabled="disabled"  value="<?php echo utf8_decode($nom_persona); ?>">
		</div>
	</div>
	<div class="row form-group">
		<div class="col col-md-3"><label for="text-input" class=" form-control-label">Usuario :</label></div>
		<div class="col-12 col-md-9">
            <input type='text' class="form-control" disabled="disabled"  value="<?php echo utf8_decode($correo); ?>">
		</div>
	</div>
	<div class="row form-group">
		<div class="col col-md-3"><label for="text-input" class=" form-control-label">Clave actual :</label></div>
		<div class="col-12 col-md-9">
        	<div class="input-group">
                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                <input type='password' id="claveact"  name="claveact" placeholder="Calve actual" class="form-control" value="">
                <div class="input-group-addon"><i onclick="muestra_calve('claveact')" class="fa fa-eye"></i></div>
            </div>
		</div>
	</div>
	<div class="row form-group">
		<div class="col col-md-3"><label for="text-input" class=" form-control-label">Nueva Clave :</label></div>
		<div class="col-12 col-md-9">
        	<div class="input-group">
                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                <input type='password' id="clavenew"  name="clavenew" placeholder="Nueva clave" class="form-control" onkeyup="fuerza_clave(this.id);"  value="">
                <div class="input-group-addon"><i  onclick="muestra_calve('clavenew')" class="fa fa-eye"></i></div>
            </div>
		</div>
	</div>
	<div class="row form-group">
		<div class="col col-md-3"><label for="text-input" class=" form-control-label">Confirmacion :</label></div>
		<div class="col-12 col-md-9">
        	<div class="input-group">
                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                <input type='password' id="claveconfir"  name="claveconfir" placeholder="Nueva clave" class="form-control" onkeyup="compara_clave();" value="">
                <div class="input-group-addon"><i onclick="muestra_calve('claveconfir')" class="fa fa-eye"></i></div>
             </div>
		</div>
	</div>
</div>
<input type='hidden' name='codigo' id="codigo" value='<?php	echo $codigo; ?>'>
<input type='hidden' name='opcion'  id="opcion" value='<?php echo $op; ?>'>
		
