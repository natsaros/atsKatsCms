<!DOCTYPE html>
<html lang="en">

<?php
$page = $_GET["page"];
if (!isset($page) && $page == "") {
    define('ADMIN_PAGE_ID', 'dashboard');
} else {
    define('ADMIN_PAGE_ID', $page);
}
?>


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
