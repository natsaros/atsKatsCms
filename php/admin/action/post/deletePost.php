<?php
$id = $_GET['id'];

if (isEmpty($id)) {
    addInfoMessage("Choose post to delete");
    Redirect(getAdminRequestUri() . PageSections::POSTS . DS . "posts");
}

try {
    $post2delete = PostHandler::getPostByID($id);
    if (isNotEmpty($post2delete)) {
        if ($post2delete->getState() == PostStatus::PUBLISHED) {
            addInfoMessage("Post '" . $post2delete->getTitle() . "' is published and cannot be deleted");
        } else {
            $deletePostRes = PostHandler::deletePost($id);
            if ($deletePostRes == null || !$deletePostRes) {
                addErrorMessage("Post failed to be deleted");
            } else {
                ImageUtil::removeImageFromFileSystem(POSTS_PICTURES_ROOT, $id);
                addSuccessMessage("Post successfully deleted");
            }
        }
    } else {
        addInfoMessage(ErrorMessages::WENT_WRONG);
    }
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

Redirect(getAdminRequestUri() . PageSections::POSTS . DS . "posts");