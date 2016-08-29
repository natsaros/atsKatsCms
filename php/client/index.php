<?php
if (!isset($_GET["id"])) {
    $pageId = "home";
} else {
    $pageId = $_GET["id"];
}
?>

<?php require("header.php"); ?>

<body id=<?php echo $pageId; ?>>

<?php require("menu.php"); ?>

<?php

switch ($pageId) {
    case "about":
        require("about.php");
        break;
    case "program":
        require("program.php");
        break;
    case "contact":
        require("contactUs.php");
        break;
    case "home":
        require("home.php");
        break;
    default:
        require("home.php");
        break;
}
?>

<?php require("footer.php"); ?>
</body>