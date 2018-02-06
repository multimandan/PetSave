<!DOCTYPE html>
<html>
  <head>
    <title>Logging off</title>
  </head>
  <body>
    <?php
      endSession();
    ?>
  </body>
</html>

<?php

session_start();

function endSession() {
  if(isset($_SESSION['login_user'])) {
    // proceed with ending session
    unset($_SESSION['login_user']);
    session_unset();
    session_destroy();
    session_write_close();
  }
    sleep(0.5);
    header("Location: index.php");
}
?>
