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
        <?php $pageTitle = "How did you end up here?";?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <?php echo $pageTitle; ?>
                </h1>
            </div>
        </div>

        <?php require(ADMIN_NAV_PATH . "messageSection.php"); ?>
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