<?php
$post = PostHandler::getPostByIDWithDetails($_GET["post_friendly_url"]);
?>

<div id="fb-root"></div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/el_GR/sdk.js#xfbml=1&version=v2.9&appId=1861331620818807";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<div class="container-fluid text-center belowHeader blogContainer">
    <div class="row">
        <div class="col-sm-12">
            <div class="blogHeaderTitle">
                <p><?php echo $post->getTitle(); ?></p>
                <div class="blogTitlesBorder"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="blogPostImage" style="background: url('<?php echo ImageUtil::renderBlogImage($post->getImagePath()); ?>') no-repeat center 60% /cover;"></div>
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
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("http://fitnesshousebypenny.gr/blog/" . transliterateString($post->getTitle())); ?>" class="fa fa-facebook" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=545,width=560');return false;"></a>
                <a href="#" class="fa fa-twitter" target="_blank"></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="blogPostBorder"></div>
    </div>
    <div class="fb-comments" data-href="http://fitnesshousebypenny.gr/home" data-width="100%" data-numposts="5"></div>
</div>