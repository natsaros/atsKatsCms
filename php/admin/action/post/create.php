<?php
$title = safe_input($_POST[PostHandler::TITLE]);
$text = $_POST[PostHandler::TEXT];
$userID = safe_input($_POST[PostHandler::USER_ID]);
$imagePath = safe_input($_POST[PostHandler::IMAGE_PATH]);
if (isEmpty($imagePath)) {
    $imagePath = FormHandler::getFormPictureDraftName(PostHandler::IMAGE);
}

if (isEmpty($title) || isEmpty($text)) {
    addErrorMessage("Please fill in required info");
}

if (isNotEmpty($imagePath)) {
    $image2Upload = FormHandler::validateUploadedImage(PostHandler::IMAGE);
}

if (hasErrors()) {
    FormHandler::setSessionForm('updatePostForm', $_POST[FormHandler::PAGE_ID]);
    Redirect(getAdminRequestUri() . PageSections::POSTS . DS . "updatePost");
}

try {
    $imgContent = (isNotEmpty($imagePath) && isNotEmpty($image2Upload)) ? ImageUtil::readImageContentFromFile($image2Upload) : false;

    $post2Create = Post::create();
    $post2Create->setTitle($title)->setFriendlyTitle(transliterateString($title))->setUserId($userID)->setText($text);

    if ($imgContent) {
        //only saving in filesystem for performance reasons
        $post2Create->setImagePath($imagePath);
        //save image content also in blob on db for back up reasons if needed
//        $post2Create->setImagePath($imagePath)->setImage($imgContent);
    }

    $postRes = PostHandler::createPost($post2Create);
    if ($postRes !== null || $postRes) {
        FormHandler::unsetFormSessionToken();
        addSuccessMessage("Post '" . $post2Create->getTitle() . "' successfully created");
        //save image under id of created post in file system
        if (isNotEmpty($imagePath) && isNotEmpty($image2Upload)) {
            $fileName = basename($image2Upload[ImageUtil::NAME]);
            ImageUtil::saveImageToFileSystem(POSTS_PICTURES_ROOT, $postRes, $fileName, $imgContent);
        }
    } else {
        addErrorMessage("Post '" . $post2Create->getTitle() . "' failed to be created");
    }

} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

if (hasErrors()) {
    Redirect(getAdminRequestUri() . PageSections::POSTS . DS . "updatePost");
} else {
    Redirect(getAdminRequestUri() . PageSections::POSTS . DS . "posts");
}