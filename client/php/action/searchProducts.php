<?php
$minPrice = $_POST['minPrice'];
$maxPrice = $_POST['maxPrice'];
$category = $_POST['category'];
$selectedCategory = $_POST['selectedCategory'];

$searchUrl = getRootUri() . PRODUCT_CATEGORIES_PATH . DS . $category . "?minPrice=" . $minPrice . "&maxPrice=" . $maxPrice;
if (isNotEmpty($selectedCategory)){
    $searchUrl .= "&selectedCategory=" . $selectedCategory;
}
Redirect($searchUrl);
