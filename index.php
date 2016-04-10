<!DOCTYPE html>
<html lang="gr">
<?php
$REQUEST_URI = $_SERVER['REQUEST_URI'];
$REQUEST_URI = preg_replace("/[^\/]+$/", "", $REQUEST_URI);

//regex to remove everything before last slash
//$pageId = preg_replace("/^.*\//s", "", $_SERVER['REQUEST_URI']);
//regex to remove everything after dot(.)
//so what remains is the page id (index,about,contact etc...)
//$pageId = preg_replace("/\..+/", "", $pageId);
//$pageId = ;
if (!isset($_GET["id"])) {
    $pageId = "home";
}else{
    $pageId = $_GET["id"];
}
?>

<?php require("php/header.php"); ?>

<body id=<?php echo $pageId; ?>>

<?php require("php/menu.php"); ?>

<?php

switch ($pageId) {
    case "about":
        require("php/about.php");
        break;
    case "program":
        require("php/program.php");
        break;
    case "contact":
        require("php/contactUs.php");
        break;
    case "home":
        require("php/home.php");
        break;
    default:
        require("php/home.php");
        break;
}
?>

<?php require("php/footer.php"); ?>
</body>
</html>

