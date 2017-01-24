<!DOCTYPE html>
<html lang="gr">

<?php header("Content-type: text/html; charset=utf-8"); ?>
<?php require_once("php/common/siteFunctions.php"); ?>

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