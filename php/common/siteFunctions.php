<?php
//Set custom Error Handler
function exception_error_handler($severity, $message, $file, $line) {
    //TODO : check this is not throwing correct error in DB->connect()
    if (mysqli_connect_errno()) {
        echo sprintf("Connect failed: %s\n", mysqli_connect_error());
    }
    throw new SystemException($message);
}

//set_error_handler("exception_error_handler");
set_error_handler("exception_error_handler", E_ALL & ~E_NOTICE);

//define all system variables needed
defineSystemVariables();

function getRootPath() {
//    $uri = preg_replace(getRootUri(), "", PHP_ROOT_PATH);
    $uri = preg_replace("/php/", "", PHP_ROOT_PATH);
    $uri = preg_replace("/\\/+/", "/", $uri);
    return $uri;
}

require_once(CLASSES_ROOT_PATH . 'exception' . DS . 'ErrorMessages.php');
require_once(CLASSES_ROOT_PATH . 'exception' . DS . 'SystemException.php');
require_once(CLASSES_ROOT_PATH . 'db' . DS . 'DB.php');
require_once(CLASSES_ROOT_PATH . 'db' . DS . 'UserFetcher.php');
require_once(CLASSES_ROOT_PATH . 'db' . DS . 'PostFetcher.php');
require_once(CLASSES_ROOT_PATH . 'Globals.php');
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
    if (isAdminAction()) {
        $uri = preg_replace("/admin[\/]action[\/].*/", "", $uri);
    } else if (isAdmin()) {
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
    initLoadDb();
    initGallery();
    initLogFile();
}

function initLoadDb() {
    $db = getDb();

    if (!$db->isInitialized($db)) {
        $init_queries = $db->db_schema_from_file();
        $result = $db->multi_query($init_queries);
        if ($result === false) {
            throw new SystemException('Database has not been initialized');
        }
        Globals::set('DB', $db);
    }
}

;

function initGallery() {
    if (!file_exists(PICTURES_ROOT)) {
        mkdir(PICTURES_ROOT, 0777, true);
    }

    if (!file_exists(VIDEOS_ROOT)) {
        mkdir(VIDEOS_ROOT, 0777, true);
    }

    if (!file_exists(DOCUMENTS_ROOT)) {
        mkdir(DOCUMENTS_ROOT, 0777, true);
    }
}

function initLogFile() {
    if (!file_exists(LOGS_ROOT)) {
        mkdir(LOGS_ROOT, 0777, true);
    }
    define('LOG_FILE', LOGS_ROOT . CONF_LOG_FILE);
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
    if (!headers_sent()) {
        if (is_null($refreshRate)) {
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
 * @throws SystemException
 */
function getDb() {
    if (is_null(Globals::get('DB'))) {
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
    if (isNotEmpty($userStr)) {
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
    if (file_exists(($path))) {
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
    if (file_exists(($path))) {
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
    if (!isset($_SESSION[MessageTypes::ERROR_MESSAGES])) {
        $_SESSION[MessageTypes::ERROR_MESSAGES] = [];
    }
    return array_push($_SESSION[MessageTypes::ERROR_MESSAGES], $msg);
}

/**
 * @param $msg string
 * @return int
 */
function addSuccessMessage($msg) {
    if (!isset($_SESSION[MessageTypes::SUCCESS_MESSAGES])) {
        $_SESSION[MessageTypes::SUCCESS_MESSAGES] = [];
    }

    return array_push($_SESSION[MessageTypes::SUCCESS_MESSAGES], $msg);
}

/**
 * @param $msg string
 * @return int
 */
function addInfoMessage($msg) {
    if (!isset($_SESSION[MessageTypes::INFO_MESSAGES])) {
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
    if (!$check) {
        if (is_array($val)) {
            $check = empty(array_filter($val));
        } else if (is_numeric($val)) {
            $check = is_null($val);
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
    if (isNotEmpty($data)) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
    }
    return $data;
}

/**
 * @param $name
 * @return string
 * @throws SystemException
 */
function renderImage($name) {
    $allowedTypes = [];
    if (isNotEmpty(ALLOWED_TYPES)) {
        $allowedTypes = explode('|', ALLOWED_TYPES);
    }

    $mimes = [];
    foreach ($allowedTypes as $type) {
        $mimes[$type] = 'image/' . $type;
    }

    $defaultUser = 'default.png';
    if (isNotEmpty($name)) {
        $tmp = explode('.', $name);
        $ext = strtolower(end($tmp));
    } else {
        $tmp = explode('.', $defaultUser);
        $ext = strtolower(end($tmp));
    }

    $file = PICTURES_ROOT . $name;
    if (is_dir($file) || !file_exists($file)) {
        $file = PICTURES_ROOT . $defaultUser;
    }
//header('content-type: ' . $mimes[$ext]);
//header('content-disposition: inline; filename="' . $name . '";');
//readfile(getRootPath() . $file);

    $content = file_get_contents($file);
    $base64 = base64_encode($content);
    return 'data:' . $mimes[$ext] . ';base64,' . $base64;
}

/**
 * Defines all system variables for the system to work
 */
function defineSystemVariables() {
    defined('PHP_POSTFIX') or define('PHP_POSTFIX', '.php');
    defined('ADMIN_STR') or define('ADMIN_STR', 'admin');
    defined('NAV_STR') or define('NAV_STR', 'navigation');
    defined('ACTION_STR') or define('ACTION_STR', 'action');
    defined('COMMON_STR') or define('COMMON_STR', 'common');
    defined('CLASSES_STR') or define('CLASSES_STR', 'classes');

    defined('REQUEST_URI') or define('REQUEST_URI', getRootUri());

//define('DS', DIRECTORY_SEPARATOR);
    defined('DS') or define('DS', "/");

    if (!defined('PHP_ROOT_PATH')) {
        $str = dirname(__DIR__) . DS;
        $str = preg_replace("/\\\\/", DS, $str);
        define('PHP_ROOT_PATH', $str);
    }

    defined('ADMIN_ROOT_PATH') or define('ADMIN_ROOT_PATH', PHP_ROOT_PATH . ADMIN_STR . DS);
    defined('ADMIN_NAV_PATH') or define('ADMIN_NAV_PATH', PHP_ROOT_PATH . ADMIN_STR . DS . NAV_STR . DS);
    defined('ADMIN_ACTION_PATH') or define('ADMIN_ACTION_PATH', PHP_ROOT_PATH . ADMIN_STR . DS . ACTION_STR . DS);
    defined('COMMON_ROOT_PATH') or define('COMMON_ROOT_PATH', PHP_ROOT_PATH . COMMON_STR . DS);
    defined('CLASSES_ROOT_PATH') or define('CLASSES_ROOT_PATH', COMMON_ROOT_PATH . CLASSES_STR . DS);

    defined('ASSETS_URI') or define('ASSETS_URI', REQUEST_URI . 'assets' . DS);
    defined('CSS_URI') or define('CSS_URI', ASSETS_URI . 'css' . DS);
    defined('JS_URI') or define('JS_URI', ASSETS_URI . 'js' . DS);

    defined('GALLERY_ROOT') or define('GALLERY_ROOT', getRootPath() . 'gallery' . DS);
    defined('PICTURES_ROOT') or define('PICTURES_ROOT', GALLERY_ROOT . 'pictures' . DS);
    defined('VIDEOS_ROOT') or define('VIDEOS_ROOT', GALLERY_ROOT . 'videos' . DS);
    defined('DOCUMENTS_ROOT') or define('DOCUMENTS_ROOT', GALLERY_ROOT . 'docs' . DS);
    defined('LOGS_ROOT') or define('LOGS_ROOT', getRootPath() . 'logs' . DS);
}

/**
 * logs system exceptions to file
 * @param SystemException $ex
 */
function logError($ex) {
    error_log($ex->errorMessage() . " with code: " . $ex->getCode(), 3, LOG_FILE);
}

?>