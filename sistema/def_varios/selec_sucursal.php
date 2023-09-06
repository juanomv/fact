

 <?php 
	if($_GET["op"]=="sucursal"){//cuando se selcciona parroquia
		$sucursal=$_POST["sucursal"];
		if($_GET["hijo"]=="punto_emision"){//llenamos sector?>
			<select name="punto_emision" id="punto_emision" class="form-control" size="1"  >
				<option value="-1">-- Seleccione caja ---</option>
				<?php $sql="select rcodigo,rnombre from sis.web_sel_catalogo('".get_sesion("usuario")."','".get_sesion("rol")."','CAJA','".$sucursal."')";
				$res=pg_query($conn,$sql);
				while ($reg=pg_fetch_array($res))
				{ ?> <option value="<?php echo $reg["rcodigo"];?>" ><?php echo utf8_decode($reg["rnombre"]);?> </option> 
				<?php } ?>
			</select> 
            
<?php 	} //fin de if($_GET["hijo"]=="parroquia")
	}//fin de if($_GET["op"]=="provincia")
?> 