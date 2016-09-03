<?php
$fileName = ADMIN_PAGE_ID;
if (strpos(ADMIN_PAGE_ID, 'panelsWells') !== false) {
    $fileName = 'panels-wells';
}

@include(ADMIN_ROOT_PATH . $fileName . '.php');
?>