<!DOCTYPE html>
<html>
  <head>
    <title>PHP Captcha Demo</title>
    <link rel="stylesheet" href="0-dummy.css">
  </head>
  <body>
    <form method="post" action="3-submit.php">
      <!-- (A) FORM FIELDS -->
      <label>Name</label>
      <input name="name" type="text" required value="Jon Doe">
      <label>Email</label>
      <input name="email" type="email" required value="jon@doe.com">

      <!-- (B) CAPTCHA HERE -->
      <label>Are you human?</label>
      <?php
      require "1-captcha.php";
      $PHPCAP->prime();
      $PHPCAP->draw();
      ?>
      <input name="captcha" type="text" required>

      <!-- (C) GO! -->
      <input type="submit" value="Go!">
    </form>
  </body>
</html>