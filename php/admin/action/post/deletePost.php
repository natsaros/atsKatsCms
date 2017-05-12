<?php
$id = $_GET['id'];

if (isEmpty($id)) {
    addInfoMessage("Choose post to delete");
    Redirect(getAdminRequestUri() . "posts");
}

try {
    $post2delete = PostFetcher::getPostByID($id);
    if ($post2delete->getState() == PostStatus::PUBLISHED) {
        addInfoMessage("Post '" . $post2delete->getTitle() . "' is published and cannot be deleted");
    } else {
        $deletePostRes = PostFetcher::deletePost($id);

        if ($deletePostRes == null || !$deletePostRes) {
            addErrorMessage("Post failed to be deleted");
        } else {
            addSuccessMessage("Post successfully deleted");
        }
    }
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
    // you can exit or die here if you prefer - also you can log your error,
    // or any other steps you wish to take
}

Redirect(getAdminRequestUri() . "posts");