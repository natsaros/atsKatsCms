<?php
$posts = PostHandler::fetchAllActivePostsWithDetails();
?>

<div class="container-fluid text-center belowHeader blogContainer">

    <?php
    /* @var $post Post */
    foreach ($posts as $key => $post) { ?>
        <div class="row">
            <div class="col-sm-3">
                <div class="blogImage" style="background: url('<?php echo renderImage($post->getImagePath()); ?>') no-repeat center 60% /cover;"></div>
            </div>
            <div class="col-sm-9">
                <div class="row row-no-padding">
                    <div class="col-sm-12">
                        <div class="blogPostPreviewTitle">
                            <?php echo $post->getTitle(); ?>
                        </div>
                    </div>
                </div>
                <div class="row row-no-padding">
                    <div class="col-sm-12">
                        <div class="blogPostPreviewText">
                            <?php echo postTextPreview($post->getText()); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="blogReadMore">
                    <a href="<?php echo REQUEST_URI ?>blog/<?php echo transliterateString($post->getID()); ?>">
                        Διαβάστε περισσότερα...
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="blogBorder"></div>
        </div>
    <?php } ?>
</div>