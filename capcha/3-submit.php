<?php
// (A) LOAD CAPTCHA LIBRARY
require "1-captcha.php";

// (B) VERIFIED - DO SOMETHING
if ($PHPCAP->verify($_POST["captcha"])) {
  $result = "Congrats, CAPTCHA is correct.";
  print_r($_POST);
}

// (C) NOPE
else { echo "CAPTCHA does not match!"; }