<?php
if (!isset($_GET["id"])) {
    $pageId = "home";
} else {
    $pageId = $_GET["id"];
}

if (isset($_GET["action"])) {
    $action = $_GET["action"];
}

try {
    initLoad();
} catch (SystemException $e) {
    logError($e);
    require(COMMON_ROOT_PATH . 'noDb.php');
    return;
}
?>
<?php if (isEmpty($action)) {
    //Default behavior: if no action is set to happen navigation occurs.
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