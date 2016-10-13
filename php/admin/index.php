<?php

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
} else { ?>
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