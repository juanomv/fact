
<?php //} //fin if($_GET["direc"]) 
//else{	
	if($_POST["op_busca_windows"]=="producto"){include("selec_producto.php");}
	if($_GET["op"]=="categoria"){//
		if($_GET["hijo"]=="sub_categoria"){
			$categoria=$_POST["categoria"];?>
			<select name="sub_categoria" id="sub_categoria" class="form-control">
                <option >--Seleccion--</option>
                <?php 
				$sql="select codigo,nombre from inv.sub_categoria where empresa='".get_sesion("empresa")."' and categoria='".$categoria."' order by nombre";
                $res=pg_query($conn,$sql);
                while ($reg=pg_fetch_array($res))
                { ?>	<option value="<?php echo $reg["codigo"];?>" ><?php echo $reg["nombre"];?> </option> <?php } ?>
			</select> 
<?php 		}
	}
?>