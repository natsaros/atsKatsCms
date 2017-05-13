<?php
//TODO : implement - hint (do it in general way. Class and then call function. Change url from where this has been called)
$id = $_GET['id'];
$status = $_GET['status'];
try {
    $updateUserStatusRes = UserHandler::updateUserStatus($id, $status);

    if($updateUserStatusRes == null || !$updateUserStatusRes) {
        addErrorMessage("User status failed to be changed");
    } else {
        addSuccessMessage("User status successfully changed");
    }
} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}
Redirect(getAdminRequestUri() . 'users');