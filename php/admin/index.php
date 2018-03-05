<?php
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

if (!isset($action) || isEmpty($action)) {
    //Default behavior: if no action is set to happen navigation occurs.

    if (!isLoggedIn()) {
        include(ADMIN_ROOT_PATH . 'login.php');
    } else {
        $page = $_GET["page"];
        if (isEmpty($page)) {
            if (isNotEmpty(DEV_MODE) && DEV_MODE) {
                define('ADMIN_PAGE_ID', PageSections::DASHBOARD);
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