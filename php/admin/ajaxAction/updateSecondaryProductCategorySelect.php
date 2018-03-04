<?php
$currentProductCategoryId = $_POST["currentProductCategoryId"];
$productCategories = ProductCategoryHandler::fetchAllActiveProductCategoriesForAdmin();

$result = '<option value="">Please Select</option>';

if(!is_null($productCategories) && count($productCategories) > 0) {
    foreach ($productCategories as $key => $productCategory){
        if ($currentProductCategoryId != $productCategory->getID()) {
            $result .= '<option value="'. $productCategory->getID() .'">' . $productCategory->getTitle() . '</option>';
        }
    }
}

echo $result;