<?php
if (!is_session_started()) {
    session_start();
}

if (isset($_GET["action"])) {
    $action = $_GET["action"];
}

initLoad();

if (isEmpty($action)) {
    //Default behavior: if no action is set to happen navigation occurs.

    $page = $_GET["page"];
    if (isEmpty($page)) {
        if(isNotEmpty(DEV_MODE) && DEV_MODE) {
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
    //All action pass through here
    require_safe(ADMIN_ACTION_PATH . $action . PHP_POSTFIX);
}
?>