<?php
function getLocalizedText($key){
    $locale = $_SESSION['locale'];
    $string_properties = json_decode(file_get_contents("./i18N/" . $locale . ".json"), true);
    echo $string_properties[$key];
}
