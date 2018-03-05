<?php
function getLocalizedText($key) {
    $language = $_SESSION['locale'];
    $string_properties = json_decode(file_get_contents("./i18N/" . $language . ".json"));
    echo $string_properties[$key];
}
