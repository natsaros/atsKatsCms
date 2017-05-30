<?php
if (!is_session_started()) {
    session_start();
}

if (isset($_GET["action"])) {
    $action = $_GET["action"];
}

try {
    initLoad();
} catch (SystemException $e) {
    logError($e);
    require(COMMON_ROOT_PATH . 'noDb.php');
    return;
}

if (isEmpty($action)) {
    //Default behavior: if no action is set to happen navigation occurs.

    $page = $_GET["page"];
    if (isEmpty($page)) {
        if (isNotEmpty(DEV_MODE) && DEV_MODE) {
            define('ADMIN_PAGE_ID', 'dashboard');
        } else {
            define('ADMIN_PAGE_ID', 'users');
        }
    } else {
        define('ADMIN_PAGE_ID', $page);
    }

    if (!isLoggedIn()) {
        include(ADMIN_ROOT_PATH . 'login.php');
    } else {
        include(COMMON_ROOT_PATH . "adminNavigation.php");
    }
} else {
    try {
        //All action pass through here
        require_safe(ADMIN_ACTION_PATH . $action . PHP_POSTFIX);
    } catch (SystemException $e) {
        logError($e);
        addErrorMessage(ErrorMessages::WENT_WRONG);
        $statusCode = 500;
        $status_string = $statusCode . ' ' . 'Internal Server Error';
        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $status_string, true, $statusCode);
        require(ADMIN_ROOT_PATH . '404.php');
    }
}
?>