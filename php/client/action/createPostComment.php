<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'comments' . DS . 'Comment.php');

$comment = $_POST[CommentHandler::COMMENT];
$userId = $_POST[CommentHandler::USER_ID];
$postId = $_POST[CommentHandler::POST_ID];
$friendlyTitle = $_POST[PostHandler::FRIENDLY_TITLE];

try{
    $comment2Insert = Comment::create();
    $comment2Insert->setPostId(safe_input($postId))->setUserId(safe_input($userId))->setComment(safe_input($comment));
    $commentRes = CommentHandler::createComment($comment2Insert);
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

Redirect(getBlogUri() . $friendlyTitle);