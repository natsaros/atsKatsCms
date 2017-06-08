<?php
$posts = PostHandler::fetchAllActivePostsWithDetails();
$isGridStyle = SettingsHandler::getSettingValueByKey(Setting::BLOG_STYLE) === 'grid';

?>

<div class="container-fluid text-center belowHeader blogContainer">
    <?php if(!is_null($posts) && count($posts) > 0) { ?>
<!--        <div class="blogPostsViewTypes">-->
<!--            <a href="javascript:void(0);" class="blogPostsViewType active" data-viewType="postsViewTypeList">-->
<!--                <img src="--><?php //echo ASSETS_URI ?><!--img/list.png">-->
<!--            </a>-->
<!--            <a href="javascript:void(0);" class="blogPostsViewType" data-viewType="postsViewTypeGrid">-->
<!--                <img src="--><?php //echo ASSETS_URI ?><!--img/grid.png">-->
<!--            </a>-->
<!--        </div>-->

        <?php if($isGridStyle) { ?>
            <div id="postsViewTypeGrid">
                <?php
                $count = 0;
                if($count == 0) {
                ?>
                <div class="row">
                    <?php
                    }
                    /* @var $post Post */
                    foreach($posts as $key => $post) {
                    $count++;
                    ?>
                    <div class="col-sm-4">
                        <div class="row row-no-padding row-no-margin">
                            <div class="col-sm-12">
                                <div class="blogImageGrid"
                                     style="background: url('<?php echo ImageUtil::renderBlogImage($post); ?>') no-repeat center 60% /cover;"></div>
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
                        <div class="row row-no-padding">
                            <div class="col-sm-12">
                                <div class="blogPostsDateGrid">
                                    <?php echo date_format(date_create($post->getActivationDate()), 'd M Y'); ?>
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
                                        Διαβάστε Περισσότερα...
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($count == 3 || $key == (sizeof($posts) - 1)) {
                    $count = 0; ?>
                </div>
            <?php
            }
            }
            ?>
            </div>
        <?php } else { ?>
            <div id="postsViewTypeList">
                <?php
                /* @var $post Post */
                foreach($posts as $key => $post) { ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="blogImageList"
                                         style="background: url('<?php echo ImageUtil::renderBlogImage($post); ?>') no-repeat center 60% /cover;"></div>
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
                                            <div class="blogPostsDateList">
                                                <?php echo date_format(date_create($post->getActivationDate()), 'd M Y'); ?>
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
                                            Διαβάστε Περισσότερα...
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
        <?php } ?>
    <?php } ?>
</div>