<?php
$posts = PostHandler::fetchAllActivePostsWithDetails();
?>

<div class="container-fluid text-center belowHeader blogContainer">

<!--    DEN MPOROUSA NA APOFASISW KAI EBALA KAI TA DUO :P -->
<!--    EDW THA MPOYN EIKONIDIA-->
    <div style="text-align:center;margin-bottom: 50px;">
        <a href="javascript:void(0);" id="postListLink" style="text-decoration:underline;" onclick="$('#postsList').fadeIn();$('#postsGrid').hide();$(this).css('text-decoration', 'underline');$('#postGridLink').css('text-decoration', 'none');">List</a>
        <a href="javascript:void(0);" id="postGridLink" onclick="$('#postsGrid').fadeIn();$('#postsList').hide();$(this).css('text-decoration', 'underline');$('#postListLink').css('text-decoration', 'none');">Grid</a>
    </div>


    <div id="postsList">
        <?php
        foreach ($posts as $key => $post) { ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="blogImageList" style="background: url('<?php echo ImageUtil::renderBlogImage($post->getImagePath()); ?>') no-repeat center 60% /cover;"></div>
                        </div>
                        <div class="col-sm-9">
                            <div class="row row-no-padding">
                                <div class="col-sm-12">
                                    <div class="blogPostPreviewTitleList">
                                        <?php echo $post->getTitle(); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-no-padding">
                                <div class="col-sm-12">
                                    <div class="blogPostPreviewTextList">
                                        <?php echo postTextPreview($post->getText(), "list"); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="blogReadMore">
                                <a href="<?php echo REQUEST_URI ?>blog/<?php echo transliterateString($post->getFriendlyTitle()); ?>">
                                    Διαβάστε περισσότερα...
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="blogBorder"></div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div id="postsGrid" style="display: none;">
        <?php
        $count = 0;
        if ($count == 0) {
        ?>
        <div class="row">
            <?php
            }
            foreach ($posts as $key => $post) {
            $count++;
            ?>
            <div class="col-sm-4">
                <div class="row row-no-padding row-no-margin">
                    <div class="col-sm-12">
                        <div class="blogImageGrid" style="background: url('<?php echo ImageUtil::renderBlogImage($post->getImagePath()); ?>') no-repeat center 60% /cover;"></div>
                    </div>
                </div>
                <div class="row row-no-padding row-no-margin">
                    <div class="col-sm-12">
                        <div class="blogPostPreviewTitleGrid">
                            <?php echo $post->getTitle(); ?>
                            <div class="blogTitlesBorderGrid"></div>
                        </div>
                    </div>
                </div>
                <div class="row row-no-padding row-no-margin">
                    <div class="col-sm-12">
                        <div class="blogPostPreviewTextGrid">
                            <?php echo postTextPreview($post->getText(), "grid"); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="blogReadMore">
                            <a href="<?php echo REQUEST_URI ?>blog/<?php echo transliterateString($post->getFriendlyTitle()); ?>">
                                Διαβάστε περισσότερα...
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($count == 3 || $key == (sizeof($posts) - 1)) {
            $count = 0; ?>
        </div>
    <?php
    }
    }
    ?>
    </div>
</div>