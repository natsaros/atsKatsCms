<?php
$title = safe_input($_POST[PostHandler::TITLE]);
$text = $_POST[PostHandler::TEXT];
$userID = safe_input($_POST[PostHandler::USER_ID]);

$imageValid = true;
$image2Upload = $_FILES[PostHandler::IMAGE];
if ($image2Upload['error'] !== UPLOAD_ERR_NO_FILE) {
    $imageValid = ImageUtil::validateImageAllowed($image2Upload);
}

$imagePath = safe_input($_POST[PostHandler::IMAGE_PATH]);

if (isEmpty($title) || isEmpty($text)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . "updatePost");
}

if (!$imageValid) {
    addInfoMessage("Please select a valid image file");
    Redirect(getAdminRequestUri() . "updatePost");
}

try {
    $imgContent = ImageUtil::readImageContentFromFile($image2Upload);
    $post2Create = Post::create();
    $post2Create->setTitle($title)->setFriendlyTitle(transliterateString($title))->setUserId($userID)->setText($text);

    if ($imgContent) {
        //save image content also in blob on db for back up reasons if needed
        $post2Create->setImagePath($imagePath)->setImage($imgContent);
    }

    $postRes = PostHandler::createPost($post2Create);
    if ($postRes !== null || $postRes) {
        addSuccessMessage("Post '" . $post2Create->getTitle() . "' successfully created");
        //save image under id of created post in file system
        ImageUtil::saveImageToFileSystem($postRes, $image2Upload);
    } else {
        addErrorMessage("Post '" . $post2Create->getTitle() . "' failed to be created");
    }

} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

if (hasErrors()) {
    Redirect(getAdminRequestUri() . "updatePost");
} else {
    Redirect(getAdminRequestUri() . "posts");
}