

 <?php 
	if($_GET["op"]=="empresa"){//cuando se selcciona parroquia
		$empresa=$_POST["empresa"];
		if($_GET["hijo"]=="sucursal"){//llenamos sector?>
			<select name="sucursal" id="sucursal" class="form-control" size="1" onchange="carga_combo('sucursal',new Array('punto_emision'))" >
				<option value="-1">-- Seleccione sucursal ---</option>
				<?php $sql="select rcodigo,rnombre from sis.web_sel_catalogo('".get_sesion("usuario")."','".get_sesion("rol")."','SUCURSAL','".$empresa."')";
				$res=pg_query($conn,$sql);
				while ($reg=pg_fetch_array($res))
				{ ?> <option value="<?php echo $reg["rcodigo"];?>" ><?php echo utf8_decode($reg["rnombre"]);?> </option> 
				<?php } ?>
			</select> 
<?php 	} //fin de if($_GET["hijo"]=="canton")
		if($_GET["hijo"]=="punto_emision"){//llenamos sector?>
			<select name="punto_emision" id="punto_emision" class="form-control" size="1"   >
				<option value="-1">-- Seleccione caja ---</option>
			</select> 
<?php 	} //fin de if($_GET["hijo"]=="parroquia")
	}//fin de if($_GET["op"]=="provincia")
?> 