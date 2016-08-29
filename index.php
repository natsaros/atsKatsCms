<!DOCTYPE html>
<html lang="gr">

<?php header("Content-type: text/html; charset=utf-8"); ?>
<?php require("php/common/siteFunctions.php"); ?>

<?php
if (isAdmin()) {
    @include("php/admin/index.php");
} else {
    @include("php/client/index.php");
}
?>
</html>

