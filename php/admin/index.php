<?php
session_start();

if(file_exists(COMMON_ROOT_PATH . 'config.php')) {
    require_once(COMMON_ROOT_PATH . 'config.php');
}

$page = $_GET["page"];
if(!isset($page) || $page == null || $page == "") {
    define('ADMIN_PAGE_ID', 'dashboard');
} else {
    define('ADMIN_PAGE_ID', $page);
}
?>

<?php

initLoad();

if(!isLoggedIn()) {
    @include(ADMIN_ROOT_PATH . 'login.php');
} else {

    if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

    if(!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
    } else if(time() - $_SESSION['CREATED'] > 1800) {
        // session started more than 30 minutes ago
        session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
        $_SESSION['CREATED'] = time();  // update creation time
    }
    ?>


    <!DOCTYPE html>
    <html lang="en">
    <?php require("adminHeader.php"); ?>
    <?php require("adminJs.php"); ?>

    <body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php require("navBar.php"); ?>

        <div id="page-wrapper">
            <?php
            @include(ROOT_PATH . "common" . DS . "adminNavigation.php");
            ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    </body>

    </html>

<?php } ?>