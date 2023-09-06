<?php
//print_r($_POST);
session_start();
//$_SESSION["autenticado"]= "NO";
session_unset();
//alert('Salio satizfactoriamente del sistema');
session_destroy();
echo "<script type=''>window.location='./index.php';</script>";
?>