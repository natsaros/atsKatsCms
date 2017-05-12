<?php require("pageHeader.php"); ?>

<?php require("messageSection.php"); ?>

<?php

$postId = $_GET["id"];
$isCreate = isEmpty($postId);
//TODO server side validation
/*include('validatePost.php');*/ ?>

<?php
$loggedInUser = getFullUserFromSession();
if($isCreate) {
    $currentPost = Post::create();
} else {
    $currentPost = PostFetcher::getPostByIDWithDetails($postId);
}
?>


<div class="row">
    <div class="col-lg-12">
        <?php
        $postUrl = getAdminActionRequestUri() . "post";
        $action = $isCreate ? $postUrl . DS . "create" : $postUrl . DS . "update";
        ?>
        <form name="updatePostForm" role="form" action="<?= $action ?>" data-toggle="validator" method="post">
            <input type="hidden" name="<?= PostFetcher::USER_ID ?>" value="<?= $loggedInUser->getID() ?>"/>
            <input type="hidden" name="<?= PostFetcher::STATE ?>" value="<?= $currentPost->getState() ?>"/>
            <input type="hidden" name="<?= PostFetcher::ID ?>" value="<?= $currentPost->getID() ?>"/>
            <div class="form-group">
                <label class="control-label" for="title_input">Title</label>
                <input class="form-control" placeholder="Title"
                       name="<?= PostFetcher::TITLE ?>" id="title_input" required
                       value="<?= $currentPost->getTitle() ?>"
                >
            </div>
            <div class="form-group">
                <label class="control-label" for="content_input">Content</label>
                <textarea class="editor" name="<?= PostFetcher::TEXT ?>" id="content_input" required>
                    <?= $currentPost->getText() ?>
                </textarea>
            </div>
            <div class="text-right form-group">
                <a type="button" href="<?= getAdminRequestUri() . 'posts' ?>"
                   class="btn btn-default">Back</a>
                <input type="submit" name="submit" class="btn btn-primary" value="Save" placeholder="Save"/>
            </div>
        </form>
    </div>
</div>