<?php
//TODO : implement - hint (do it in general way. Class and then call function. Change url from where this has been called)
$id = $_GET['id'];
$status = $_GET['status'];

if (isEmpty($id) || isEmpty($status)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . "productCategories");
}

try {
    $updateProductCategoryRes = ProductCategoryHandler::updateProductCategoryStatus($id, $status);

    if ($updateProductCategoryRes !== null || $updateProductCategoryRes) {
        addSuccessMessage("Product category status successfully changed");
    } else {
        addErrorMessage("Product category status failed to be changed");
    }
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}
Redirect(getAdminRequestUri() . 'productCategories');