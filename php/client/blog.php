<?php
$posts = PostFetcher::fetchAllActivePostsWithDetails();
?>

<div class="container text-center">

    <?php
    /* @var $post Post */
    foreach ($posts as $key => $post) { ?>
        <div class="training">
            <div class="row fundamentals">
                <div class="col-sm-12">
                    <?php echo $post->getTitle(); ?>
                    <?php echo $post->getText(); ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>