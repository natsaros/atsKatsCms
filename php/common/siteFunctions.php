<?php
//Set custom Error Handler
function exception_error_handler($severity, $message, $file, $line) {
    //TODO : check this is not throwing correct error in DB->connect()
    if(mysqli_connect_errno()) {
        echo sprintf("Connect failed: %s\n", mysqli_connect_error());
    }
    throw new SystemException($message, 0, $severity, $file, $line);
}

set_error_handler("exception_error_handler", E_ALL & ~E_NOTICE);

define('PHP_POSTFIX', '.php');
define('ADMIN_STR', 'admin');
define('NAV_STR', 'navigation');
define('ACTION_STR', 'action');
define('COMMON_STR', 'common');
define('CLASSES_STR', 'classes');

define('REQUEST_URI', getRootUri());

//define('DS', DIRECTORY_SEPARATOR);
define('DS', "/");

if(!defined('PHP_ROOT_PATH')) {
    $str = dirname(__DIR__) . DS;
    $str = preg_replace("/\\\\/", DS, $str);
    define('PHP_ROOT_PATH', $str);
}

function getRootPath() {
    $uri = preg_replace(getRootUri(), "", PHP_ROOT_PATH);
    $uri = preg_replace("/php/", "", $uri);
    $uri = preg_replace("/\\/+/", "/", $uri);
    return $uri;
}

define('ADMIN_ROOT_PATH', PHP_ROOT_PATH . ADMIN_STR . DS);
define('ADMIN_NAV_PATH', PHP_ROOT_PATH . ADMIN_STR . DS . NAV_STR . DS);
define('ADMIN_ACTION_PATH', PHP_ROOT_PATH . ADMIN_STR . DS . ACTION_STR . DS);
define('COMMON_ROOT_PATH', PHP_ROOT_PATH . COMMON_STR . DS);
define('CLASSES_ROOT_PATH', COMMON_ROOT_PATH . CLASSES_STR . DS);

define('ASSETS_URI', REQUEST_URI . 'assets' . DS);
define('CSS_URI', ASSETS_URI . 'css' . DS);
define('JS_URI', ASSETS_URI . 'js' . DS);
define('USER_PICS', ASSETS_URI . 'pics' . DS);

require_once(CLASSES_ROOT_PATH . 'SystemException.php');
require_once(CLASSES_ROOT_PATH . 'DB.php');
require_once(CLASSES_ROOT_PATH . 'Globals.php');
require_once(CLASSES_ROOT_PATH . 'UserFetcher.php');
require_once(CLASSES_ROOT_PATH . 'MessageTypes.php');

/**
 * @return bool
 */
function isAdmin() {
    return strpos(getRequestUri(), ADMIN_STR) !== false;
}

/**
 * @return bool
 */
function isAdminAction() {
    return strpos(getRequestUri(), ADMIN_STR . '/' . ACTION_STR) !== false;
}

/**
 * @return string
 */
function getRootUri() {
    $uri = $_SERVER['REQUEST_URI'];
    $uri = preg_replace("/[^\/]+$/", "", $uri);
    if(isAdminAction()) {
        $uri = preg_replace("/admin[\/]action[\/].*/", "", $uri);
    } else if(isAdmin()) {
        $uri = preg_replace("/admin[\/].*/", "", $uri);
    }
    return $uri;
}

/**
 * @return string
 */
function getRequestUriNoDelim() {
    $uri = $_SERVER['REQUEST_URI'];
    $uri = preg_replace("/\?[^\?]+$/", "", $uri);
    return $uri;
}

/**
 * @return string
 */
function getRequestUri() {
    return getRequestUriNoDelim() . "/";
}

/**
 * @return string
 */
function getAdminRequestUriNoDelim() {
    return getRootUri() . ADMIN_STR;
}

/**
 * @return string
 */
function getAdminRequestUri() {
    return getAdminRequestUriNoDelim() . DS;
}

/**
 * @return string
 */
function getAdminActionRequestUri() {
    return getAdminRequestUriNoDelim() . DS . ACTION_STR . DS;
}

/**
 * @return string
 */
function getActiveAdminPage() {
    $uri = $_SERVER['REQUEST_URI'];
    $page_id = preg_replace("/[^\/][\w]+(?=\?)/", "", $uri);
    return $page_id;
}

/**
 * @throws SystemException
 */
function initLoad() {

    $db = getDb();

    if(!$db->isInitialized($db)) {
        $init_queries = $db->db_schema();
        $result = $db->query($init_queries);
        if($result === false) {
            throw new SystemException('Database has not been initialized');
        }
        Globals::set('DB', $db);
    }
}

/**
 * @return bool
 */
function isLoggedIn() {
    return isNotEmpty(getUserFromSession());
}

/**
 * @param $url
 * @param null $refreshRate
 * @param bool $permanent
 */
function Redirect($url, $refreshRate = null, $permanent = false) {
    if(!headers_sent()) {
        if(is_null($refreshRate)) {
            header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
        } else {
            header('Refresh : ' . $refreshRate . 'url: ' . $url, true, ($permanent === true) ? 301 : 302);
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $url . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
        echo '</noscript>';
    }

    exit();
}

/**
 * @return DB
 */
function getDb() {
    if(is_null(Globals::get('DB'))) {
        Globals::set('DB', DB::getInstance());
    }
    return Globals::get('DB');
}

/**
 * @return string
 */
function getUserFromSession() {
    return $_SESSION['USER'];
}

/**
 * @return User
 */
function getFullUserFromSession() {
    $userStr = $_SESSION['FULL_USER'];
    if(isNotEmpty($userStr)) {
        return unserialize($userStr);
    }
    return null;
}

/**
 * @param User $user
 */
function setUserToSession($user) {
    $_SESSION['USER'] = $user->getUserName();
    $_SESSION['FULL_USER'] = serialize($user);
    $_SESSION['timeout'] = time();
    $_SESSION['valid'] = true;
}

/**
 * @param $path
 * @throws SystemException
 */
function require_safe($path) {
    if(file_exists(($path))) {
        require($path);
    } else {
        throw new SystemException($path . " doesn't exist");
    }
}

/**
 * @param $path
 * @return bool
 * @throws SystemException
 */
function exists_safe($path) {
    if(file_exists(($path))) {
        return true;
    } else {
        throw new SystemException($path . " doesn't exist");
    }
}

/**
 * @param $msg string
 * @return int
 */
function addErrorMessage($msg) {
    if(!isset($_SESSION[MessageTypes::ERROR_MESSAGES])) {
        $_SESSION[MessageTypes::ERROR_MESSAGES] = [];
    }
    return array_push($_SESSION[MessageTypes::ERROR_MESSAGES], $msg);
}

/**
 * @param $msg string
 * @return int
 */
function addSuccessMessage($msg) {
    if(!isset($_SESSION[MessageTypes::SUCCESS_MESSAGES])) {
        $_SESSION[MessageTypes::SUCCESS_MESSAGES] = [];
    }

    return array_push($_SESSION[MessageTypes::SUCCESS_MESSAGES], $msg);
}

/**
 * @param $msg string
 * @return int
 */
function addInfoMessage($msg) {
    if(!isset($_SESSION[MessageTypes::INFO_MESSAGES])) {
        $_SESSION[MessageTypes::INFO_MESSAGES] = [];
    }
    return array_push($_SESSION[MessageTypes::INFO_MESSAGES], $msg);
}

/**
 * @return array
 */
function consumeSuccessMessages() {
    return consumeMessage(MessageTypes::SUCCESS_MESSAGES);
}

/**
 * @return array
 */
function consumeErrorMessages() {
    return consumeMessage(MessageTypes::ERROR_MESSAGES);
}

/**
 * @return array
 */
function consumeInfoMessages() {
    return consumeMessage(MessageTypes::INFO_MESSAGES);
}

/**
 * @param $arrayName string
 * @return array
 */
function consumeMessage($arrayName) {
    $ret = $_SESSION[$arrayName];
    unset($_SESSION[$arrayName]);
    return $ret;
}

/**
 * @param $val mixed
 * @return bool
 */
function isEmpty($val) {
    $check = !isset($val) || $val == null;
    if(!$check) {
        if(is_array($val)) {
            $check = empty(array_filter($val));
        } else {
            $check = empty($val);
        }
    }
    return $check;
}

/**
 * @param $val mixed
 * @return bool
 */
function isNotEmpty($val) {
    return !isEmpty($val);
}

/**
 * @param $data
 * @return string
 */
function safe_input($data) {
    if(isNotEmpty($data)) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
    }
    return $data;
}

function renderImage($name) {
    $mimes = array
    (
        'jpg' => 'image/jpg',
        'jpeg' => 'image/jpg',
        'gif' => 'image/gif',
        'png' => 'image/png'
    );
    $defaultUser = 'default.png';
    if(isNotEmpty($name)) {
        $tmp = explode('.', $name);
        $ext = strtolower(end($tmp));
    } else {
        $tmp = explode('.', $defaultUser);
        $ext = strtolower(end($tmp));
    }

    $file = getRootPath() . USER_PICS . $name;
    if(!file_exists($file)) {
        $file = getRootPath() . USER_PICS . $defaultUser;
    }
//header('content-type: ' . $mimes[$ext]);
//header('content-disposition: inline; filename="' . $name . '";');
//readfile(getRootPath() . $file);

    $content = file_get_contents($file);
    $base64 = base64_encode($content);
    return 'data:' . $mimes[$ext] . ';base64,' . $base64;
}

?>