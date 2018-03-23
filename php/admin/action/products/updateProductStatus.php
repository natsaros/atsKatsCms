<?php
//TODO : implement - hint (do it in general way. Class and then call function. Change url from where this has been called)
$id = $_GET['id'];
$status = $_GET['status'];

if (isEmpty($id) || isEmpty($status)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . "products");
}

try {
    $updateProductRes = ProductHandler::updateProductStatus($id, $status);

    if ($updateProductRes !== null || $updateProductRes) {
        addSuccessMessage("Product status successfully changed");
    } else {
        addErrorMessage("Product status failed to be changed");
    }
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}
Redirect(getAdminRequestUri() . 'products');