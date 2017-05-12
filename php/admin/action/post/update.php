<?php
$ID = safe_input($_POST[PostFetcher::ID]);
$title = safe_input($_POST[PostFetcher::TITLE]);
$state = safe_input($_POST[PostFetcher::STATE]);
$userID = safe_input($_POST[PostFetcher::USER_ID]);
$text = safe_input($_POST[PostFetcher::TEXT]);

if(isEmpty($title)) {
    //    TODO : add php side form validation message
    //    addInfoMessage("Please fill in required info");
}
try {
    $post2Create = Post::createSimplePost($ID, $title, $state, $userID);
    $post2Create->setText($text);

    $postRes = PostFetcher::update($post2Create);
    if($postRes == null || !$postRes) {
        addErrorMessage("Post " . $post2Create->getTitle() . " failed to be updated");
    } else {
        addSuccessMessage("Post " . $post2Create->getTitle() . " successfully updated");
    }

} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
    // you can exit or die here if you prefer - also you can log your error,
    // or any other steps you wish to take
}
Redirect(getAdminRequestUri() . "posts");