<?php
$currentURL = $_POST['currentURL'];
$language = $_POST['language'];

$_SESSION['locale'] = $language;
$_SESSION['string.properties'] = json_decode(file_get_contents("./i18N/" . $language . ".json"), true);

Redirect($currentURL);