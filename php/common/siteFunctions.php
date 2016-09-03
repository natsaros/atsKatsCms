<?php
define('ADMIN_STR', 'admin');
define('REQUEST_URI', getRootUri());

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(__DIR__) . DS);
define('ADMIN_ROOT_PATH', ROOT_PATH . ADMIN_STR . DS);

define('ASSETS_URI', REQUEST_URI . 'assets' . DS);
define('CSS_URI', ASSETS_URI . 'css' . DS);
define('JS_URI', ASSETS_URI . 'js' . DS);

function isAdmin() {
    return strpos(getRequestUri(), ADMIN_STR) !== false;
}

function getRootUri() {
    $uri = $_SERVER['REQUEST_URI'];
    $uri = preg_replace("/[^\/]+$/", "", $uri);
    if (isAdmin()) {
        $uri = preg_replace("/admin[\/]*$/", "", $uri);
    }
    return $uri;
}

function getRequestUri() {
    $uri = $_SERVER['REQUEST_URI'];
    $uri = preg_replace("/\?[^\?]+$/", "", $uri);
    return $uri . "/";
}

function getAdminRequestUri() {
    return getRootUri() . ADMIN_STR . DS;
}

function getActiveAdminPage() {
    $uri = $_SERVER['REQUEST_URI'];
    $page_id = preg_replace("/[^\/][\w]+(?=\?)/", "", $uri);
    return $page_id;
}

?>