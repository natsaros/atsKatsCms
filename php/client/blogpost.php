<?php if (!is_null($post)) { ?>
    <script src="<?php echo ASSETS_URI ?>js/fb-login.min.js"></script>

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
                    <?php echo date_format(date_create($post->getActivationDate()), 'd M Y'); ?>
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
                <img style="width:100px;" src="<?php echo ASSETS_URI ?>img/loading-dots.gif">
            </div>
        </div>

        <div class="row" id="newCommentSection" style="display: none;">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="commentsTitle">
                            Σχόλια
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