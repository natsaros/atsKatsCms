<?php
//Set custom Error Handler
function exception_error_handler($severity, $message, $file, $line) {
    //TODO : check this is not throwing correct error in DB->connect()
    if(mysqli_connect_errno()) {
        $message = mysqli_connect_error();
//        echo sprintf("Connect failed: %s\n", mysqli_connect_error());
    }
    throw new SystemException($message);
}

//set_error_handler("exception_error_handler");
set_error_handler("exception_error_handler", E_ALL & ~E_NOTICE);

//define all system variables needed
defineSystemVariables();

loadAppClasses();

function getRootPath() {
//    $uri = preg_replace(getRootUri(), "", PHP_ROOT_PATH);
    $uri = preg_replace("/php/", "", PHP_ROOT_PATH);
    $uri = preg_replace("/\\/+/", "/", $uri);
    return $uri;
}

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
 * @return bool
 */
function isAdminModal() {
    return strpos(getRequestUri(), ADMIN_STR . '/' . MODAL_STR) !== false;
}

/**
 * @return bool
 */
function isUnderBlogPath() {
    return strpos(getRequestUri(), BLOG_PATH) !== false;
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
    } else if(isUnderBlogPath()) {
        $uri = preg_replace("/blog[\/].*/", "", $uri);
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
function getAdminModalRequestUri() {
    return getAdminRequestUriNoDelim() . DS . MODAL_STR . DS;
}

/**
 * @return string
 */
function getBlogUri() {
    return getRootUri() . BLOG_PATH . DS;
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

    if(!$db->isInitialized($db)) {
        $init_queries = $db->db_schema_from_file();
        $result = $db->multi_query($init_queries);
        if($result === false) {
            throw new SystemException('Database has not been initialized');
        }
        Globals::set('DB', $db);
    }
}

function initGallery() {
    createDirIfNotExists(PICTURES_ROOT);
    createDirIfNotExists(VIDEOS_ROOT);
    createDirIfNotExists(DOCUMENTS_ROOT);
}

function initLogFile() {
    createDirIfNotExists(LOGS_ROOT);
    define('LOG_FILE', LOGS_ROOT . CONF_LOG_FILE);
}

/**
 * @param $path
 */
function createDirIfNotExists($path) {
    if(!file_exists($path)) {
        mkdir($path, 0777, true);
    }
}

/**
 * @return bool
 */
function isLoggedIn() {
    return is_session_started() && isNotEmpty(getUserFromSession());
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
 * @throws SystemException
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
 * @return boolean
 */
function hasErrors() {
    $errorMessages = $_SESSION[MessageTypes::ERROR_MESSAGES];
    return isset($errorMessages) && isNotEmpty($errorMessages) && count($errorMessages) > 0;
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
        } else if(is_numeric($val)) {
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
 * @return mixed
 */
function safe_input($data) {
    if(isNotEmpty($data)) {
        if(is_array($data)) {
            $moded = array();
            foreach($data as $value) {
                $value = trim($value);
                $value = stripslashes($value);
                $value = htmlspecialchars($value);
                $moded[] = $value;
            }
            $data = $moded;
        } else {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
        }
    }
    return $data;
}

/**
 * Defines all system variables for the system to work
 */
function defineSystemVariables() {
    defined('PHP_POSTFIX') or define('PHP_POSTFIX', '.php');
    defined('ADMIN_STR') or define('ADMIN_STR', 'admin');
    defined('NAV_STR') or define('NAV_STR', 'navigation');
    defined('ACTION_STR') or define('ACTION_STR', 'action');
    defined('MODAL_STR') or define('MODAL_STR', 'modal');
    defined('COMMON_STR') or define('COMMON_STR', 'common');
    defined('CLASSES_STR') or define('CLASSES_STR', 'classes');
    defined('BLOG_PATH') or define('BLOG_PATH', 'blog');

    defined('REQUEST_URI') or define('REQUEST_URI', getRootUri());

//define('DS', DIRECTORY_SEPARATOR);
    defined('DS') or define('DS', "/");

    if(!defined('PHP_ROOT_PATH')) {
        $str = dirname(__DIR__) . DS;
        $str = preg_replace("/\\\\/", DS, $str);
        define('PHP_ROOT_PATH', $str);
    }

    defined('ADMIN_ROOT_PATH') or define('ADMIN_ROOT_PATH', PHP_ROOT_PATH . ADMIN_STR . DS);
    defined('ADMIN_NAV_PATH') or define('ADMIN_NAV_PATH', PHP_ROOT_PATH . ADMIN_STR . DS . NAV_STR . DS);
    defined('ADMIN_MODAL_NAV_PATH') or define('ADMIN_MODAL_NAV_PATH', PHP_ROOT_PATH . ADMIN_STR . DS . NAV_STR . DS . MODAL_STR . DS);
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

function loadAppClasses() {
    require_once(CLASSES_ROOT_PATH . 'exception' . DS . 'ErrorMessages.php');
    require_once(CLASSES_ROOT_PATH . 'exception' . DS . 'SystemException.php');
    require_once(CLASSES_ROOT_PATH . 'db' . DS . 'DB.php');
    require_once(CLASSES_ROOT_PATH . 'db' . DS . 'UserHandler.php');
    require_once(CLASSES_ROOT_PATH . 'db' . DS . 'PostHandler.php');
    require_once(CLASSES_ROOT_PATH . 'db' . DS . 'CommentHandler.php');
    require_once(CLASSES_ROOT_PATH . 'db' . DS . 'GroupHandler.php');
    require_once(CLASSES_ROOT_PATH . 'db' . DS . 'AccessRightsHandler.php');
    require_once(CLASSES_ROOT_PATH . 'db' . DS . 'SettingsHandler.php');
    require_once(CLASSES_ROOT_PATH . 'util' . DS . 'ImageUtil.php');
    require_once(CLASSES_ROOT_PATH . 'security' . DS . 'PageSections.php');
    require_once(CLASSES_ROOT_PATH . 'Globals.php');
    require_once(CLASSES_ROOT_PATH . 'MessageTypes.php');
}

/**
 * logs system exceptions to file
 * @param SystemException $ex
 */
function logError($ex) {
    error_log($ex->errorMessage() . " with code: " . $ex->getCode() . "\r\n", 3, LOG_FILE);
}

/**
 * @return array
 */
function greek_array() {
    return array(
        'α' => 'a',
        'β' => 'b',
        'γ' => 'g',
        'δ' => 'd',
        'ε' => 'e',
        'ζ' => 'z',
        'η' => 'i',
        'θ' => 'th',
        'ι' => 'i',
        'κ' => 'k',
        'λ' => 'l',
        'μ' => 'm',
        'ν' => 'n',
        'ξ' => 'ks',
        'ο' => 'o',
        'π' => 'p',
        'ρ' => 'r',
        'ς' => 's',
        'σ' => 's',
        'τ' => 't',
        'υ' => 'u',
        'φ' => 'f',
        'χ' => 'x',
        'ψ' => 'ps',
        'ω' => 'w',
        'Α' => 'a',
        'Β' => 'b',
        'Γ' => 'g',
        'Δ' => 'd',
        'Ε' => 'e',
        'Ζ' => 'z',
        'Η' => 'i',
        'Θ' => 'th',
        'Ι' => 'i',
        'Κ' => 'k',
        'Λ' => 'l',
        'Μ' => 'm',
        'Ν' => 'n',
        'Ξ' => 'ks',
        'Ο' => 'o',
        'Π' => 'p',
        'Ρ' => 'r',
        'Σ' => 's',
        'Τ' => 't',
        'Υ' => 'u',
        'Φ' => 'f',
        'Χ' => 'x',
        'Ψ' => 'ps',
        'Ω' => 'w',
        'ά' => 'a',
        'έ' => 'e',
        'ή' => 'i',
        'ί' => 'i',
        'ό' => 'o',
        'ύ' => 'u',
        'ώ' => 'w',
        'ϊ' => 'i',
        'ΐ' => 'i',
        'Ά' => 'a',
        'Έ' => 'e',
        'Ή' => 'i',
        'Ί' => 'i',
        'Ό' => 'o',
        'Ύ' => 'u',
        'Ώ' => 'w',
        'Ϊ' => 'i',
        ' ' => '-',
        '.' => '',
        ',' => '',
        '_' => '-',
        '=' => '-',
        '+' => '-',
        '/' => '-',
        '\'' => '',
        '"' => '',
        '/' => '',
        ']' => '',
        '[' => '',
        '{' => '',
        '}' => '',
        '\\' => '',
        '|' => '',
        ')' => '',
        '(' => '',
        ':' => '',
        ';' => '',
        '*' => '',
        '&' => '',
        '^' => '',
        '%' => '',
        '$' => '',
        '#' => '',
        '@' => '',
        '!' => '',
        '~' => '',
        '<' => '',
        '>' => ''
    );
}

/**
 * @param $txt
 * @return string
 *
 * Returns friendly text in english
 */
function transliterateString($txt) {
    $transliterationTable = greek_array();
    return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);
}

/**
 * @param $postText
 * @param $viewType
 * @return string
 *
 * Returns part of text of the post as a preview
 */
function postTextPreview($postText, $viewType) {
    $maxLength = 0;
    if($viewType == "grid") {
        $maxLength = 100;
    } else if($viewType == "list") {
        $maxLength = 250;
    }
    if(strlen($postText) > $maxLength) {
        return substr(strip_tags($postText), 0, $maxLength) . "...";
    } else {
        return $postText;
    }
}

/**
 * @return bool
 */
function is_session_started() {
    if(php_sapi_name() !== 'cli') {
        if(version_compare(phpversion(), '5.4.0', '>=')) {
            return session_status() === PHP_SESSION_ACTIVE;
        } else {
            return session_id() !== '';
        }
    }
    return false;
}

/**
 * @param array $params
 * @param array $paramValues
 * @return string
 * @throws SystemException
 */
function addParamsToUrl($params, $paramValues) {
    $urlParams = '';
    if(isNotEmpty($params) && isNotEmpty($paramValues)) {
        if(count($params) !== count($paramValues)) {
            throw new SystemException('Parameter names and values don\'t match!');
        }

        foreach($params as $key => $param) {
            if($key == 0) {
                $urlParams .= '?' . $param . '=' . $paramValues[$key];
            } else {
                $urlParams .= '&' . $param . '=' . $paramValues[$key];
            }
        }
    }
    return $urlParams;
}

/**
 * @return bool
 */
function isAjax() {
    $isAjaxPost = isset($_POST['isAjax']) ? $_POST['isAjax'] : false;
    $isAjaxGet = isset($_GET['isAjax']) ? $_GET['isAjax'] : false;
    $is_ajax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || $isAjaxPost || $isAjaxGet;
    return $is_ajax;
}

/**
 * @param $user User
 * @param $accessRight
 * @return bool
 */
function hasAccess($user, $accessRight) {
    $hasAccess = false;
    if(isNotEmpty($user->getAccessRights())) {
        $hasAccess = in_array(AccessRight::ALL, $user->getAccessRightsStr()) || in_array($accessRight, $user->getAccessRightsStr());
    }
    return $hasAccess;
}

?>