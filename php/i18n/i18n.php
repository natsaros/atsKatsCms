<?php
function getLocalizedText($key){
    $string_properties = $_SESSION['string.properties'];
    echo $string_properties[$key];
}
