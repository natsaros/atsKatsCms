<?php
$title = safe_input($_POST[PostFetcher::TITLE]);
$userID = safe_input($_POST[PostFetcher::USER_ID]);

if(isEmpty($title)) {
    //    TODO : add php side form validation message
    //    addInfoMessage("Please fill in required info");
}

try {
    $post2Create = Post::create();
    $post2Create->setTitle($title)->setUserId($userID);

    $postRes = PostFetcher::createPost($post2Create);
    if($postRes == null || !$postRes) {
        addErrorMessage("Post " . $post2Create->getTitle() . " failed to be created");
    } else {
        addSuccessMessage("Post " . $post2Create->getTitle() . " successfully created");
    }

} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
    // you can exit or die here if you prefer - also you can log your error,
    // or any other steps you wish to take
}
Redirect(getAdminRequestUri() . "posts");