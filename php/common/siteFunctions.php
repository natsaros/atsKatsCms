<?php
define('ADMIN_STR', 'admin');
define('COMMON_STR', 'common');

define('REQUEST_URI', getRootUri());

define('DS', DIRECTORY_SEPARATOR);

if (!defined('ROOT_PATH'))
    define('ROOT_PATH', dirname(__DIR__) . DS);

define('ADMIN_ROOT_PATH', ROOT_PATH . ADMIN_STR . DS);
define('COMMON_ROOT_PATH', ROOT_PATH . COMMON_STR . DS);

define('ASSETS_URI', REQUEST_URI . 'assets' . DS);
define('CSS_URI', ASSETS_URI . 'css' . DS);
define('JS_URI', ASSETS_URI . 'js' . DS);


function db_connect() {
    static $connection;

    // Try and connect to the database, if a connection has not been established yet
    if (!isset($connection)) {
        $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    // If connection was not successful, handle the error
    if ($connection === false) {
        /*$die = sprintf(
                "There doesn't seem to be a connection to %s database. I need this before we can get started.",
                DB_NAME
            ) . '</p>';
        echo $die;
        die();*/
        return mysqli_connect_error();
    }
    return $connection;
}

function db_query($query) {
    // Connect to the database
    $connection = db_connect();

    // Query the database
    $result = mysqli_query($connection, $query);

    return $result;
}

function db_error() {
    $connection = db_connect();
    return mysqli_error($connection);
}

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

function loggedIn() {
    return true;
}

function Redirect($url, $permanent = false) {
    if (headers_sent() === false) {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}

?>