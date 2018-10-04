<?php
$id = $_GET['id'];

if (isEmpty($id)) {
    addInfoMessage("Choose product to delete");
    Redirect(getAdminRequestUri() . PageSections::PRODUCTS . DS . "products");
}

try {
    $product2delete = ProductHandler::getProductByID($id);
    if (isNotEmpty($product2delete)) {
        if ($product2delete->getState() == ProductStatus::ACTIVE) {
            addInfoMessage("Product '" . $product2delete->getTitle() . "' is active and cannot be deleted");
        } else {
            $deleteProductRes = ProductHandler::deleteProduct($id);
            if ($deleteProductRes == null || !$deleteProductRes) {
                addErrorMessage("Product failed to be deleted");
            } else {
                ImageUtil::removeImageFromFileSystem(PRODUCTS_PICTURES_ROOT, $id);
                addSuccessMessage("Product successfully deleted");
            }
        }
    } else {
        addInfoMessage(ErrorMessages::WENT_WRONG);
    }
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

Redirect(getAdminRequestUri() . PageSections::PRODUCTS . DS . "products");