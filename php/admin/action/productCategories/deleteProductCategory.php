<?php
$id = $_GET['id'];

if (isEmpty($id)) {
    addInfoMessage("Choose product category to delete");
    Redirect(getAdminRequestUri() . "productCategories");
}

try {
    $productCategory2delete = ProductCategoryHandler::getProductCategoryByID($id);
    if (isNotEmpty($productCategory2delete)) {
        if ($productCategory2delete->getState() == ProductCategoryStatus::ACTIVE) {
            addInfoMessage("Product category '" . $productCategory2delete->getTitle() . "' is active and cannot be deleted");
        } else {
            $productCategoryAssignedToProduct = ProductHandler::isProductCategoryAssignedToProducts($id);
            if (!$productCategoryAssignedToProduct){
                $deleteProductCategoryRes = ProductCategoryHandler::deleteProductCategory($id);
                if ($deleteProductCategoryRes == null || !$deleteProductCategoryRes) {
                    addErrorMessage("Product Category failed to be deleted");
                } else {
                    ImageUtil::removeImageFromFileSystem(PRODUCT_CATEGORIES_PICTURES_ROOT, $id);
                    addSuccessMessage("Product Category successfully deleted");
                }
            } else {
                addErrorMessage("Product Category is assigned to product and cannot be deleted");
            }
        }
    } else {
        addInfoMessage(ErrorMessages::WENT_WRONG);
    }
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

Redirect(getAdminRequestUri() . "productCategories");