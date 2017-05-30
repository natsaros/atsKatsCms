<?php
if (!isset($_GET["id"])) {
    $pageId = "home";
} else {
    $pageId = $_GET["id"];
}

try {
    initLoad();
} catch (SystemException $e) {
    logError($e);
    require(COMMON_ROOT_PATH . 'noDb.php');
    return;
}
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