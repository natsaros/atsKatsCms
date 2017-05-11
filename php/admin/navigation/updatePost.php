<?php require("pageHeader.php"); ?>

<?php require("messageSection.php"); ?>

<?php

$postId = $_GET["id"];
$isCreate = isEmpty($postId);
//TODO server side validation
/*include('validatePost.php');*/ ?>

<?php
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
            <div class="form-group">
                <label class="control-label" for="title_input">Title</label>
                <input class="form-control" placeholder="Title"
                       name="title" id="title_input" required>
            </div>
            <div class="form-group">
                <label class="control-label" for="content_input">Content</label>
                <textarea class="editor" name="content" id="content_input" required>

                </textarea>
            </div>
        </form>
    </div>
</div>