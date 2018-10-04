<?php
ob_start();
header("Content-type: text/html; charset=utf-8");

require_once("core/siteFunctions.php");
if (!is_session_started()) {
    session_start();
}
if (file_exists(COMMON_ROOT_PATH . 'config.php')) {
    require_once(COMMON_ROOT_PATH . 'config.php');
}
date_default_timezone_set(DEFAULT_TIME_ZONE);

try {
    initLoad();
} catch (Exception $e) {
    logGeneralError($e);
    require(COMMON_ROOT_PATH . 'noDb.php');
    return;
}

if (isAdmin()) {
    if (file_exists(COMMON_ROOT_PATH . 'siteSections.php')) {
        require_once(COMMON_ROOT_PATH . 'siteSections.php');
    }
    if (isAdminAction() && isEmpty($_GET["action"])) {
        @include("admin/php/404.php");
        return;
    }
    @include("admin/php/index.php");
} else {
    @include("client/php/index.php");
}