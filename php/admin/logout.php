<?php
session_start();
unset($_SESSION["USER"]);
session_unset();
session_destroy();
?>

some html here

<?php

Redirect(getAdminRequestUri(), 2);
exit();
?>
