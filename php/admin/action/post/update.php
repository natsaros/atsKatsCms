<?php
$ID = safe_input($_POST[PostHandler::ID]);
$title = safe_input($_POST[PostHandler::TITLE]);
$text = $_POST[PostHandler::TEXT];

$state = safe_input($_POST[PostHandler::STATE]);
$userID = safe_input($_POST[PostHandler::USER_ID]);

$imagePath = safe_input($_POST[PostHandler::IMAGE_PATH]);
$target_file = basename($_FILES[PostHandler::IMAGE]["name"]);

if (isEmpty($title) || isEmpty($text)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . "posts");
}
try {
    $post = Post::createSimplePost($ID, $title, $state, $userID);
    $post->setText($text)->setImagePath($imagePath);

    $postRes = PostHandler::update($post);
    if ($postRes == null || !$postRes) {
        addErrorMessage("Post '" . $post->getTitle() . "' failed to be updated");
    } else {
        addSuccessMessage("Post '" . $post->getTitle() . "' successfully updated");
    }

} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}
Redirect(getAdminRequestUri() . "posts");