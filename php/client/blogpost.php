<div id="fb-root"></div>
<script>
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/el_GR/sdk.js#xfbml=1&version=v2.9&appId=1861331620818807";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

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
                   onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=545,width=560');return false;"></a>
<!--                <a href="#" class="fa fa-facebook" target="_blank"></a>-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="blogPostBorder"></div>
    </div>
    <div class="fb-comments" data-href="http://fitnesshousebypenny.gr/home" data-width="100%" data-numposts="5"></div>
</div>