<?php
if(!isset($_GET["id"])) {
    $pageId = "home";
} else {
    $pageId = $_GET["id"];
}

initLoadDb();
?>

<!--TODO : redirect to 404 if url is wrong!!-->
<?php require("header.php"); ?>
<body id=<?= $pageId; ?>>
<?php require("menu.php");
require($pageId . ".php");
require("footer.php"); ?>
</body>