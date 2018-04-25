<?php
$loggedInUser = getFullUserFromSession();

//TODO : check access under those paths also
if (isAdminModal()) {
    $path = ADMIN_MODAL_NAV_PATH . ADMIN_PAGE_ID . PHP_POSTFIX;
} else {
    if (isNotEmpty($loggedInUser)) {
        if (PageSections::hasAccessToPageSection(ADMIN_PAGE_ID,
            getFullUserFromSession()->getAccessRightsStr())) {
            $path = ADMIN_NAV_PATH . ADMIN_PAGE_ID . PHP_POSTFIX;
        } else {
            $path = ADMIN_ROOT_PATH . '404' . PHP_POSTFIX;
        }
    }
}
try {

    if (exists_safe($path)) {
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
            // last request was more than 30 minutes ago
            session_unset();     // unset $_SESSION variable for the run-time
            session_destroy();   // destroy session data in storage
            Redirect(getAdminRequestUri() . "login");
        }
        $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

        if (!isset($_SESSION['CREATED'])) {
            $_SESSION['CREATED'] = time();
        } else if (time() - $_SESSION['CREATED'] > 1800) {
            // session started more than 30 minutes ago
            session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
            $_SESSION['CREATED'] = time();  // update creation time
        }
        ?>


        <!DOCTYPE html>
        <html lang="en">
        <?php if (isAdminModal()) { ?>
            <body>
            <div id="wrapper">
                <?php @require_safe($path); ?>
            </div>
            </body>
        <?php } else { ?>
            <?php require_safe(ADMIN_ROOT_PATH . "adminHeader.php"); ?>
            <?php require_safe(ADMIN_ROOT_PATH . "adminJS.php"); ?>
            <body>
            <div id="wrapper">
                <!-- Navigation -->
                <?php require_safe(ADMIN_ROOT_PATH . "navBar.php"); ?>
                <div id="page-wrapper">
                    <?php
                    //TODO : evolve navigation to be able to add folders under 'navigation' directory and redirect correctly
                    // now it only navigates to the php passed by name
                    @require_safe($path);
                    ?>
                </div>
            </div>
            </body>
        <?php } ?>
        </html>
    <?php }
} catch (SystemException $e) {
    logError($e);
} catch (Exception $e) {
    logGeneralError($e);
}
?>
