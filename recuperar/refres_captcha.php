<?php 
session_start();
require "../capcha/1-captcha.php";
ob_start();
$PHPCAP->prime();
$PHPCAP->draw();
$contenido_captcha =ob_get_clean();
echo '<script>$("#divCaptcha").html("'.$contenido_captcha.'");</script>';

?>