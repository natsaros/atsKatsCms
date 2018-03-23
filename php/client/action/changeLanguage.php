<?php
$currentURL = $_POST['currentURL'];
$language = $_POST['language'];

$_SESSION['locale'] = $language;

Redirect($currentURL);