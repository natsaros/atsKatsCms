<?php
$ADMIN_STR = 'admin';

$REQUEST_URI = getRootUri();

$ASSETS_URI = $REQUEST_URI . 'assets/';

$CSS_URI = $ASSETS_URI . 'css/';

$JS_URI = $ASSETS_URI . 'js/';

function isAdmin()
{
    return strpos(getRequestUri(), $GLOBALS['ADMIN_STR']) !== false;
}

function getRootUri()
{
    $uri = $_SERVER['REQUEST_URI'];
    $uri = preg_replace("/[^\/]+$/", "", $uri);
    return $uri;
}

function getRequestUri()
{
    $uri = $_SERVER['REQUEST_URI'];
    $uri = preg_replace("/\?[^\?]+$/", "", $uri);
    return $uri . "/";
}

function getAdminRequestUri()
{
    return preg_replace("/admin/", "php/admin", getRequestUri());
}

function getActiveAdminPage()
{
    $uri = $_SERVER['REQUEST_URI'];
    $page_id = preg_replace("/[^\/][\w]+(?=\?)/", "", $uri);
    return $page_id;
}

?>