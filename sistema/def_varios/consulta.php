<?php 

$opcion_win=$_POST["opcion_contenido"];
$sql_fila="select distinct varios_fila from sis.modulos where varios='S' and varios_padre in (SELECT codigo FROM sis.modulos where varios_menu='S' and pagina='".$opcion_win."')
and codigo in (Select modulo from sis.modulos_roll where roll='".get_sesion("rol")."' and acceso='1' );";
$res_fila=pg_query($conn,$sql_fila);
while ($reg_fila=pg_fetch_array($res_fila)){ $fila=$reg_fila["varios_fila"];
?>
        <!--inicio de fila-->
        <div class="row">
        	<?php 
			$sql="select * from sis.modulos where varios='S' and varios_padre in (SELECT codigo FROM sis.modulos where varios_menu='S' and pagina='".$opcion_win."') 
			and varios_fila='".$fila."' and codigo in (Select modulo from sis.modulos_roll where roll='".get_sesion("rol")."' and acceso='1' ) order by orden ;";
			$res=pg_query($conn,$sql);
			while ($reg=pg_fetch_array($res)){ ?>
            <!--inicio de bloque-->
            <div class="col-sm-6 col-lg-3">
                <a href="javascript:void(0)" onclick="Muestrac_Contenido_principal('<?php echo $reg["pagina"]; ?>','<?php echo $reg["referencia"]; ?>')" >
                <div class="card text-white <?php echo $reg["varios_color"]; ?>">
                    <div class="card-body">
                        <div class="card-left pt-1 float-left">
                            <h4 class="mb-0 fw-r">
                                <span class="text-light mt-1 m-0"><?php echo $reg["varios_texto"]; ?></span>
                            </h4>
                        </div><!-- /.card-left -->
                        <div class="card-right float-right text-right">
                            <i class="icon fade-5 icon-lg <?php echo $reg["varios_logo"]; ?>"></i>
                        </div><!-- /.card-right -->
                    </div>
                </div>
                </a>
            </div>
    		<!--fin de bloque-->
            <?php } // fin de  ?>
        </div>
        <!--fin de fila-->
<?php } // fin de  ?>