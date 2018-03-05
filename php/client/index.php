<?php
try {
    initLoad();
} catch (SystemException $e) {
    logError($e);
    require(COMMON_ROOT_PATH . 'noDb.php');
    return;
}

if (!isset($_SESSION['locale'])){
    $_SESSION['locale'] = 'el_GR';
}

?>
<?php if (!isset($action) || isEmpty($action)) {

    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

    if (!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
    } else if (time() - $_SESSION['CREATED'] > 1800) {
        // session started more than 30 minutes ago
        session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
        $_SESSION['CREATED'] = time();  // update creation time
    }

    if (!isset($_GET["id"])) {
        $pageId = "home";
    } else {
        $pageId = $_GET["id"];
    }
    //Default behavior: if no action is set to happen navigation occurs.
    try {

    ?>
    <?php require("header.php"); ?>
    <body id=<?php echo $pageId; ?>>
    <?php
    $path = dirname(__FILE__) . DS . $pageId . ".php";
    if (realpath($path)) {
        require("menu.php");
        require($path);
        require("footer.php");
    } else {
        require('404.php');
    }
    } catch (Exception $e) {
        logGeneralError($e);
        $statusCode = 500;
        $status_string = $statusCode . ' ' . 'Internal Server Error';
        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $status_string, true, $statusCode);
        require(CLIENT_ROOT_PATH . '404.php');
    }
    ?>
    </body>
<?php } else {
    try {
        //All action pass through here
        require_safe(CLIENT_ACTION_PATH . $action . PHP_POSTFIX);
    } catch (SystemException $e) {
        logError($e);
        addErrorMessage(ErrorMessages::WENT_WRONG);
        $statusCode = 500;
        $status_string = $statusCode . ' ' . 'Internal Server Error';
        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $status_string, true, $statusCode);
        require(ADMIN_ROOT_PATH . '404.php');
    }
} ?>