<?php
$ID = safe_input($_POST[PostFetcher::ID]);
$title = safe_input($_POST[PostFetcher::TITLE]);
$state = safe_input($_POST[PostFetcher::STATE]);
$userID = safe_input($_POST[PostFetcher::USER_ID]);
$text = $_POST[PostFetcher::TEXT];

if (isEmpty($title) || isEmpty($text)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . "posts");
}
try {
    $post2Create = Post::createSimplePost($ID, $title, $state, $userID);
    $post2Create->setText($text);

    $postRes = PostFetcher::update($post2Create);
    if ($postRes == null || !$postRes) {
        addErrorMessage("Post '" . $post2Create->getTitle() . "' failed to be updated");
    } else {
        addSuccessMessage("Post '" . $post2Create->getTitle() . "' successfully updated");
    }

} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}
Redirect(getAdminRequestUri() . "posts");