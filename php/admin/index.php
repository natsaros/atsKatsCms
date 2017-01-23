<?php
try {
    session_start();

    if(file_exists(COMMON_ROOT_PATH . 'config.php')) {
        require_once(COMMON_ROOT_PATH . 'config.php');
    }
    if(isset($_GET["action"])) {
        $action = $_GET["action"];
    }

    initLoad();

    if(!isset($action) || $action == null || $action == "") {
        //Default behavior: if no action is set to happen navigation occurs.

        $page = $_GET["page"];
        if(!isset($page) || $page == null || $page == "") {
            define('ADMIN_PAGE_ID', 'dashboard');
        } else {
            define('ADMIN_PAGE_ID', $page);
        }

        if(!isLoggedIn()) {
            include(ADMIN_ROOT_PATH . 'login.php');
        } else {
            include(COMMON_ROOT_PATH . "adminNavigation.php");
        }
    } else {
        //All action pass through here
        require_safe(ADMIN_ACTION_PATH . $action . PHP_POSTFIX);
    }
} catch(SystemException $ex) {
    echo $ex->errorMessage();
    // you can exit or die here if you prefer - also you can log your error,
    // or any other steps you wish to take
}
?>