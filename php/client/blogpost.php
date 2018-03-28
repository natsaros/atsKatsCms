<?php if (!is_null($post)) { ?>
    <div class="container-fluid text-center belowHeader blogContainer">
        <div class="row">
            <div class="col-sm-12">
                <div class="blogHeaderTitle">
                    <p><?php echo $post->getTitle(); ?></p>
                    <div class="blogPostTitlesBorder"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="blogPostDate">
                    <?php echo formatDateBasedOnLocale($post->getActivationDate()) . (isNotEmpty($postComments) ? "&nbsp;&nbsp;|&nbsp;&nbsp;" . count($postComments) . " comments" : "" );?>
                </div>
            </div>
        </div>
        <?php if (isNotEmpty($post->getImagePath())) { ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="blogPostImage">
                        <img src="<?php echo ImageUtil::renderBlogImage($post); ?>"/>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="blogPostTextContainer">
                    <?php echo $post->getText(); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="blogPostShareContainer">
                    Μοιράσου αυτό το άρθρο:
                    <?php
                    $append = urlencode("http://fitnesshousebypenny.gr/blog/" . $post->getFriendlyTitle());
                    $href_fb = "https://www.facebook.com/sharer/sharer.php?u=" . $append;
                    $href_twitter_title = urlencode("Fitness House by Penny - ". $post->getTitle());
                    $href_twitter_url = "https://twitter.com/share?url=" . $append . "&hashtags=fitnesshousebypenny&text=" . $href_twitter_title;
                    ?>
                    <a href="<?php echo $href_fb?>"
                       class="fa fa-facebook"
                       onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=700');return false;">
                    </a>
                    <a href="<?php echo $href_twitter_url?>"
                       class="fa fa-twitter"
                       onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=700');return false;">
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="blogPostBorder"></div>
        </div>

        <?php if(!is_null($postComments) && count($postComments) > 0) {
            foreach($postComments as $key => $postComment) { ?>
                <div class="row row-no-padding row-no-margin">
                    <div class="col-xs-12">
                        <div class="row row-no-padding row-no-margin">
                            <div class="col-xs-2 col-sm-1 post-comment-image-container">
                                <img src="<?php echo $postComment->getUser()->getImagePath();?>"/>
                            </div>
                            <div class="col-xs-10 col-sm-11 post-comment-text-container">
                                <div class="row row-no-margin">
                                    <div class="col-xs-12 post-comment">
                                        <?php echo $postComment->getComment();?>
                                    </div>
                                </div>
                                <div class="row row-no-margin post-commenter">
                                    <div class="col-xs-7">
                                        <?php echo $postComment->getUser()->getFirstName() . " " . $postComment->getUser()->getLastName();?>
                                    </div>
                                    <div class="col-xs-5" style="text-align: right;">
                                        <?php echo formatDateBasedOnLocale($postComment->getDate());?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="blogPostBorder"></div>
                </div>
                <?php
            }
        }
        ?>

        <div class="row" id="fbLoginSection">
            <div class="col-sm-12">
                <a class="facebook-login-button" href="javascript:void(0);" onclick="fbLogin();">
                    Συνδεθείτε για να σχολιάσετε το άρθρο
                    <span class="fa"></span>
                </a>
            </div>
        </div>

        <div class="row" id="loadingImg" style="display: none;">
            <div class="col-sm-12">
                <img src="<?php echo ASSETS_URI ?>img/loading-dots.gif">
            </div>
        </div>

        <div class="row" id="newCommentSection" style="display: none;">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="commentsTitle">
                            Σχόλιο
                        </div>
                    </div>
                </div>
                <?php $action = getClientActionRequestUri() . "createPostComment"; ?>
                <form method="post" accept-charset="utf-8" id="blogPostCommentsForm" action="<?php echo $action;?>">
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <textarea class="form-control" id="comments" name="<?php echo CommentHandler::COMMENT ?>" placeholder="Προσθέστε το σχόλιό σας *" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <button class="btn btn-block btn-default" type="submit" onclick="checkLoginState(true);">Δημοσίευση</button>
                        </div>
                    </div>
                    <input type="hidden" name="<?php echo PostHandler::POST_ID ?>" value="<?php echo $post->getID(); ?>"/>
                    <input type="hidden" name="<?php echo PostHandler::USER_ID ?>" id="loggedInUserId"/>
                    <input type="hidden" name="<?php echo PostHandler::FRIENDLY_TITLE ?>" value="<?php echo $post->getFriendlyTitle(); ?>"/>
                </form>
            </div>
        </div>
    </div>
<?php } else { ?>
    <!--todo: 404-->
<?php } ?>