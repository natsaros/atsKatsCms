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
    <div class="row">
        <div class="col-sm-12">
            <div class="blogPostImage"
                 style="background: url('<?php echo ImageUtil::renderBlogImage($post); ?>') no-repeat center 60% /cover;"></div>
        </div>
    </div>
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
                $href = "https://www.facebook.com/sharer/sharer.php?u=" . $append;
                ?>
                <a href="<?php echo $href?>"
                   class="fa fa-facebook"
                   onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=545,width=560');return false;">

                </a>
                <a href="#" class="fa fa-twitter" target="_blank">

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
                Συνδεθείτε στο Facebook για να σχολιάσετε το άρθρο
                <span class="fa"></span>
            </a>
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
            <div class="row">
                <div class="col-sm-6 form-group">
                    <input class="form-control" id="name" name="name" placeholder="Ονοματεπώνυμο *" type="text"
                           required>
                </div>
                <div class="col-sm-6 form-group">
                    <input class="form-control" id="email" name="email" placeholder="Email *" type="email" required>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <textarea class="form-control" id="comments" name="goal" placeholder="Γράψτε το σχόλιό σας *" rows="5"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <button class="btn btn-block btn-default" onclick="checkLoginState();">Δημοσίευση</button>
                </div>
            </div>
        </div>
    </div>
</div>