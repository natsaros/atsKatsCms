<!DOCTYPE html>
<html lang="gr">
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

require_once("php/i18n/i18n.php");

$maintenancePageEnabled = SettingsHandler::getSettingValueByKey(Setting::MAINTENANCE) === 'on';

if (!$maintenancePageEnabled){
    if (isset($_GET["action"])) {
        $action = $_GET["action"];
    }

    if (isset($_GET["ajaxAction"])) {
        $ajaxAction = $_GET["ajaxAction"];
    }

    $cookie_name = "SellinofosCookiesConsent";

    if(!isset($_COOKIE[$cookie_name])) {
        $cookies_consent = "false";
        setcookie($cookie_name, "false", time() + (10 * 365 * 24 * 60 * 60), "/");
    } else {
        $cookies_consent = $_COOKIE[$cookie_name];
    }
}

if (isset($ajaxAction) && isNotEmpty($ajaxAction)) {
    try {
        require_safe(CLIENT_AJAX_ACTION_PATH . $ajaxAction . PHP_POSTFIX);
    } catch (SystemException $e) {
        logError($e);
        addErrorMessage(ErrorMessages::WENT_WRONG);
        $statusCode = 500;
        $status_string = $statusCode . ' ' . 'Internal Server Error';
        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $status_string, true, $statusCode);
        require(ADMIN_ROOT_PATH . '404.php');
    }
} else if (!isset($action) || isEmpty($action)) {
    require("header.php");
    if ($maintenancePageEnabled){?>
        <body>
        <?php require("maintenancePage.php"); ?>
        </body>
        <?php
    } else {
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
        ?>
        <body id=<?php echo $pageId; ?>>
        <?php
        $path = dirname(__FILE__) . DS . $pageId . ".php";
        if (realpath($path)) {
            require("menu.php");
            require($path);
            require("footer.php");
            require('promotedInstance.php');
        } else {
            require("menu.php");
            require('./php/client/404.php');
            require("footer.php");
        }
        ?>
        </body>
    <?php }
} else {
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
</html>