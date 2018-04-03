<?php
$title = safe_input($_POST[PostHandler::TITLE]);
$text = $_POST[PostHandler::TEXT];
$userID = safe_input($_POST[PostHandler::USER_ID]);
$imagePath = safe_input($_POST[PostHandler::IMAGE_PATH]);

if(isEmpty($title) || isEmpty($text)) {
    addErrorMessage("Please fill in required info");
}

if(isNotEmpty($imagePath)) {
$imageValid = true;
$image2Upload = $_FILES[PostHandler::IMAGE];
if($image2Upload['error'] !== UPLOAD_ERR_NO_FILE) {
    $imageValid = ImageUtil::validateImageAllowed($image2Upload);
}

if(!$imageValid) {
        addErrorMessage("Please select a valid image file");
    }
}

if(hasErrors()) {
    if (!empty($_POST)) {
        foreach($_POST as $key => $value) {
            $_SESSION['updatePostForm'][$key] = $value;
        }
        $_SESSION['updatePostForm'][$key] = $value;
    }
    Redirect(getAdminRequestUri() . "updatePost");
}

try {
    $imgContent = (isNotEmpty($imagePath) && !$emptyFile) ? ImageUtil::readImageContentFromFile($image2Upload) : false;

    $post2Create = Post::create();
    $post2Create->setTitle($title)->setFriendlyTitle(transliterateString($title))->setUserId($userID)->setText($text);

    if($imgContent) {
        //only saving in filesystem for performance reasons
        $post2Create->setImagePath($imagePath);
        //save image content also in blob on db for back up reasons if needed
//        $post2Create->setImagePath($imagePath)->setImage($imgContent);
    }

    $postRes = PostHandler::createPost($post2Create);
    if($postRes !== null || $postRes) {
        addSuccessMessage("Post '" . $post2Create->getTitle() . "' successfully created");
        //save image under id of created post in file system
        if(isNotEmpty($imagePath) && !$emptyFile) {
            $fileName = basename($image2Upload[ImageUtil::NAME]);
            ImageUtil::saveImageToFileSystem(POSTS_PICTURES_ROOT, $postRes, $fileName, $imgContent);
        }
    } else {
        addErrorMessage("Post '" . $post2Create->getTitle() . "' failed to be created");
    }

} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

if(hasErrors()) {
    Redirect(getAdminRequestUri() . "updatePost");
} else {
    Redirect(getAdminRequestUri() . "posts");
}