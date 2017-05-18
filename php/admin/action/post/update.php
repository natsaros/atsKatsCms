<?php
$ID = safe_input($_POST[PostHandler::ID]);
$title = safe_input($_POST[PostHandler::TITLE]);
$text = $_POST[PostHandler::TEXT];

$state = safe_input($_POST[PostHandler::STATE]);
$userID = safe_input($_POST[PostHandler::USER_ID]);

$imageValid = true;
$image2Upload = $_FILES[PostHandler::IMAGE];
if($image2Upload['error'] !== UPLOAD_ERR_NO_FILE) {
    $imageValid = ImageUtil::validateImageAllowed($image2Upload);
}

$imagePath = safe_input($_POST[PostHandler::IMAGE_PATH]);
$target_file = basename($image2Upload["name"]);

if(isEmpty($title) || isEmpty($text)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . "posts");
}

if(!$imageValid) {
    addInfoMessage("Please select a valid image file");
    Redirect(sprintf(getAdminRequestUri() . "updatePost"));
}

try {
    $post = Post::createSimplePost($ID, $title, $state, $userID);
    $post->setText($text)->setImagePath($imagePath);

    $postRes = PostHandler::update($post);
    if($postRes !== null || $postRes) {
        addSuccessMessage("Post '" . $post->getTitle() . "' successfully updated");
    } else {
        addErrorMessage("Post '" . $post->getTitle() . "' failed to be updated");
    }

} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}
Redirect(getAdminRequestUri() . "posts");