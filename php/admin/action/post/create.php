<?php
$title = safe_input($_POST[PostHandler::TITLE]);
$text = $_POST[PostHandler::TEXT];

$userID = safe_input($_POST[PostHandler::USER_ID]);

$target_file = basename($_FILES[PostHandler::IMAGE]["name"]);


if (isEmpty($title) || isEmpty($text)) {
    addInfoMessage("Please fill in required info");
    Redirect(sprintf(getAdminRequestUri() . "updatePost"));
}

try {
    $post2Create = Post::create();
    $post2Create->setTitle($title)->setUserId($userID)->setText($text);

    $postRes = PostHandler::createPost($post2Create);
    if ($postRes == null || !$postRes) {
        addErrorMessage("Post '" . $post2Create->getTitle() . "' failed to be created");
    } else {
        addSuccessMessage("Post '" . $post2Create->getTitle() . "' successfully created");
    }

} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
    // you can exit or die here if you prefer - also you can log your error,
    // or any other steps you wish to take
}
Redirect(getAdminRequestUri() . "posts");