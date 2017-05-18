<?php
$title = safe_input($_POST[PostHandler::TITLE]);
$text = $_POST[PostHandler::TEXT];
$userID = safe_input($_POST[PostHandler::USER_ID]);

$image2Upload = $_FILES[PostHandler::IMAGE];
$imageValid = ImageUtil::validateImageAllowed($image2Upload);

$imagePath = safe_input($_POST[PostHandler::IMAGE_PATH]);
$target_file = basename($image2Upload["name"]);

if(isEmpty($title) || isEmpty($text)) {
    addInfoMessage("Please fill in required info");
    Redirect(sprintf(getAdminRequestUri() . "updatePost"));
}

if(!$imageValid) {
    addInfoMessage("Please select a valid image file");
    Redirect(sprintf(getAdminRequestUri() . "updatePost"));
}

try {
    $post2Create = Post::create();
    $post2Create->setTitle($title)->setFriendlyTitle(transliterateString($title))->setUserId($userID)->setText($text);

    $postRes = PostHandler::createPost($post2Create);
    if($postRes !== null || $postRes) {
        addSuccessMessage("Post '" . $post2Create->getTitle() . "' successfully created");
    } else {
        addErrorMessage("Post '" . $post2Create->getTitle() . "' failed to be created");
    }

} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
    // you can exit or die here if you prefer - also you can log your error,
    // or any other steps you wish to take
}
Redirect(getAdminRequestUri() . "posts");