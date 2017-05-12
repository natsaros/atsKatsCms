<?php
//TODO : implement - hint (do it in general way. Class and then call function. Change url from where this has been called)
$id = $_GET['id'];
$status = $_GET['status'];
try {
    $updateUserStatusRes = PostFetcher::updatePostStatus($id, $status);

    if($updateUserStatusRes == null || !$updateUserStatusRes) {
        addErrorMessage("Post status failed to be changed");
    } else {
        addSuccessMessage("Post status successfully changed");
    }
} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}
Redirect(getAdminRequestUri() . 'posts');