<?php
$posts = PostHandler::fetchAllActivePostsWithDetails();
?>

<div class="container text-center belowHeader">

    <?php
    /* @var $post Post */
    foreach ($posts as $key => $post) { ?>
        <div class="training">
            <div class="row fundamentals">
                <div class="col-sm-12">
                    <?php echo $post->getTitle(); ?>
                    <img class="img-thumbnail img-responsive"
                         src="<?php echo ImageUtil::renderImage($post->getImagePath()); ?>"
                         alt="<?php echo $post->getTitle() ?>">
                    <?php echo $post->getText(); ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>