<?php

$postId = $_GET["id"];
$isCreate = isEmpty($postId);

$loggedInUser = getFullUserFromSession();
if ($isCreate) {
    $currentPost = Post::create();
} else {
    $currentPost = PostHandler::getPostByIDWithDetails($postId);
}
$pageTitle = $isCreate ? "Create Post" : "Update Post";

FormHandler::unsetSessionForm('updatePostForm');
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $pageTitle; ?>
        </h1>
    </div>
</div>

<?php require(ADMIN_NAV_PATH . "messageSection.php"); ?>

<div class="row">
    <div class="col-lg-12">
        <?php
        $postUrl = getAdminActionRequestUri() . "post";
        $action = $isCreate ? $postUrl . DS . "create" : $postUrl . DS . "update";
        ?>
        <form name="updatePostForm" role="form" action="<?php echo $action ?>" data-toggle="validator" method="post"
              enctype="multipart/form-data">
            <input type="hidden" name="<?php echo FormHandler::PAGE_ID ?>" value="<?php echo ADMIN_PAGE_ID ?>">
            <input type="hidden" name="<?php echo PostHandler::USER_ID ?>"
                   value="<?php echo $loggedInUser->getID() ?>"/>
            <input type="hidden" name="<?php echo PostHandler::STATE ?>"
                   value="<?php echo $currentPost->getState() ?>"/>
            <input type="hidden" name="<?php echo PostHandler::ID ?>" value="<?php echo $currentPost->getID() ?>"/>

            <div class="form-group">
                <label class="control-label" for="title_input">Title *</label>
                <input class="form-control" placeholder="Title"
                       name="<?php echo PostHandler::TITLE ?>" id="title_input" required
                       value="<?php echo FormHandler::getEditFormData(PostHandler::TITLE, $currentPost->getTitle()); ?>"
                >
            </div>

            <div class="form-group">
                <label class="control-label" for="uploadImage">Image</label>
                <div class="form-group input-group">
                    <?php
                    if (!FormHandler::isTempPictureSaved()) { ?>
                        <label class="input-group-btn">
                            <span class="btn btn-primary btn-file">
                            Browse&hellip; <input type="file" style="display: none;" id="uploadImage"
                                                  name="<?php echo PostHandler::IMAGE ?>"
                                                  multiple>
                            </span>
                        </label>
                    <?php } else { ?>
                        <label class="input-group-btn">
                            <span class="btn btn-primary btn-file">
                            Browse&hellip;
                            </span>
                        </label>
                        <input type="hidden"
                               value="<?php echo FormHandler::getTempPictureToken(); ?>"
                               name="<?php echo FormHandler::TEMP_IMAGE_SAVED_TOKEN ?>"
                               class="hiddenLabel">
                    <?php } ?>
                    <input type="text"
                           value="<?php echo FormHandler::getEditFormData(PostHandler::IMAGE_PATH, $currentPost->getImagePath()); ?>"
                           name="<?php echo PostHandler::IMAGE_PATH ?>" class="form-control hiddenLabel" readonly>
                </div>
            </div>

            <div class="form-group uploadPreview">
                <?php
                if (FormHandler::isTempPictureSaved()) {
                    $draftPicturePath = FormHandler::getFormPictureDraftPath(PostHandler::IMAGE);
                    $pictureVal = ImageUtil::renderGalleryImage($draftPicturePath);
                } else {
                    $pictureVal = ImageUtil::renderBlogImage($currentPost);
                }
                ?>

                <img data-preview="true" src="<?php echo $pictureVal; ?>"/>
            </div>

            <div class="form-group">
                <label class="control-label" for="content_input">Content *</label>
                <textarea class="editor" name="<?php echo PostHandler::TEXT ?>" id="content_input" required>
                    <?php echo FormHandler::getEditFormData(PostHandler::TEXT, $currentPost->getText()); ?>
                </textarea>
            </div>
            <div class="text-right form-group">
                <a type="button" href="<?php echo getAdminRequestUri() . DS . PageSections::POSTS . DS . 'posts' ?>"
                   class="btn btn-default">Back</a>
                <input type="submit" name="submit" class="btn btn-primary" value="Save" placeholder="Save"/>
            </div>
        </form>
    </div>
</div>