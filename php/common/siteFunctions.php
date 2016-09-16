<?php
define('ADMIN_STR', 'admin');
define('COMMON_STR', 'common');
define('CLASSES_STR', 'classes');

define('REQUEST_URI', getRootUri());

define('DS', DIRECTORY_SEPARATOR);

if(!defined('ROOT_PATH'))
    define('ROOT_PATH', dirname(__DIR__) . DS);

define('ADMIN_ROOT_PATH', ROOT_PATH . ADMIN_STR . DS);
define('COMMON_ROOT_PATH', ROOT_PATH . COMMON_STR . DS);
define('CLASSES_ROOT_PATH', COMMON_ROOT_PATH . CLASSES_STR . DS);

define('ASSETS_URI', REQUEST_URI . 'assets' . DS);
define('CSS_URI', ASSETS_URI . 'css' . DS);
define('JS_URI', ASSETS_URI . 'js' . DS);

require_once(CLASSES_ROOT_PATH . 'DB.php');

function isAdmin() {
    return strpos(getRequestUri(), ADMIN_STR) !== false;
}

function getRootUri() {
    $uri = $_SERVER['REQUEST_URI'];
    $uri = preg_replace("/[^\/]+$/", "", $uri);
    if(isAdmin()) {
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

function loggedIn() {
    $db = new Db();

    $rows = $db->select("SELECT * FROM test_table");
    if($rows === false) {
        $error = $db->error();
        // Handle error - inform administrator, log to file, show error page, etc.
    }
    return $rows;
}

function Redirect($url, $permanent = false) {
    if(headers_sent() === false) {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}

?>