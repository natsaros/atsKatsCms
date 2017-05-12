<?php
$posts = PostFetcher::fetchAllActivePostsWithDetails();
?>

<div class="container text-center">

    <?php
    /* @var $post Post */
    foreach($posts as $key => $post) { ?>
        <div class="training">
            <div class="row fundamentals">
                <div class="col-sm-12">
                    <div class="textHolder">
                        <div class="genColor textHolderInside">
                            <?= $post->getText(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>