<?php
header("Content-type: text/html; charset=utf-8");
?>
<?php
try {
    ?>
<!DOCTYPE html>
<html lang="gr">
    <?php require_safe(ADMIN_ROOT_PATH . "adminHeader.php"); ?>
<body>
<div id="wrapper">
    Ooops something went wrong
</div>
</body>
</html>
    <?php
} catch (SystemException $e) {
    logError($e);
} catch (Exception $e) {
    logGeneralError($e);
}
?>