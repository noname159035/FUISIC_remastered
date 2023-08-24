<?php
global $user;
setcookie('user', $user ['name'], time () - 3600, "/");

  header('Location: /index_new.php')
?>
