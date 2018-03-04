<?php
if (!is_session_started()) {
    session_start();
}

if (isset($_GET["action"])) {
    $action = $_GET["action"];
}

if (isset($_GET["ajaxAction"])) {
    $ajaxAction = $_GET["ajaxAction"];
}

try {
    initLoad();
} catch (SystemException $e) {
    logError($e);
    require(COMMON_ROOT_PATH . 'noDb.php');
    return;
}

if (isset($ajaxAction) && isNotEmpty($ajaxAction)) {
    try {
        require_safe(ADMIN_AJAX_ACTION_PATH . $ajaxAction . PHP_POSTFIX);
    } catch (SystemException $e) {
        logError($e);
        addErrorMessage(ErrorMessages::WENT_WRONG);
        $statusCode = 500;
        $status_string = $statusCode . ' ' . 'Internal Server Error';
        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $status_string, true, $statusCode);
        require(ADMIN_ROOT_PATH . '404.php');
    }
} else if (!isset($action) || isEmpty($action)) {
    //Default behavior: if no action is set to happen navigation occurs.

    if (!isLoggedIn()) {
        include(ADMIN_ROOT_PATH . 'login.php');
    } else {
        $page = $_GET["page"];
        if (isEmpty($page)) {
            if (isNotEmpty(DEV_MODE) && DEV_MODE) {
                define('ADMIN_PAGE_ID', 'dashboard');
            } else {
                $pagesAllowed = PageSections::getPagesByAccessRights(getFullUserFromSession()->getAccessRightsStr());
                $startPage = $pagesAllowed[0];
                define('ADMIN_PAGE_ID', $startPage);
            }
        } else {
            define('ADMIN_PAGE_ID', $page);
        }

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