<?php
header("Content-type: text/html; charset=utf-8");
require_once("php/common/siteFunctions.php");
if(!is_session_started()) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="gr">

<?php
require_once("php/i18n/i18n.php");

if(file_exists(COMMON_ROOT_PATH . 'config.php')) {
    require_once(COMMON_ROOT_PATH . 'config.php');
}
?>

<?php
if(isAdmin()) {
    if(isAdminAction() && isEmpty($_GET["action"])) {
        @include("php/admin/404.php");
        return;
    }
    @include("php/admin/index.php");
} else {
    @include("php/client/index.php");
}
?>
</html>