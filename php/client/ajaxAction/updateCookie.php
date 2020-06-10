<?php
$cookie_name = $_POST["cookieName"];
$cookie_value = $_POST["cookieValue"];

setcookie($cookie_name, $cookie_value, time() + (10 * 365 * 24 * 60 * 60), "/");