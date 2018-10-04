<?php
session_start();
unset($_SESSION["USER"]);
unset($_SESSION["FULL_USER"]);
session_unset();
session_destroy();
Redirect(getAdminRequestUriNoDelim());
