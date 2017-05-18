<?php
//TODO : implement - hint (do it in general way. Class and then call function. Change url from where this has been called)
$id = $_GET['id'];
$status = $_GET['status'];

if (isEmpty($id) || isEmpty($status)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . "posts");
}

try {
    $updatePostRes = PostHandler::updatePostStatus($id, $status);

    if ($updatePostRes !== null || $updatePostRes) {
        addSuccessMessage("Post status successfully changed");
    } else {
        addErrorMessage("Post status failed to be changed");
    }
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}
Redirect(getAdminRequestUri() . 'posts');