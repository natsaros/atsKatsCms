<footer class="container text-center">
    <a class="toTop grayish" href="<?php echo $pageId ?>" title="To Top">
        <span class="glyphicon glyphicon-chevron-up"></span>
    </a>
    <ul>
        <li><a href="<?php echo REQUEST_URI ?>home">Αρχική</a></li>
        <li><a href="<?php echo REQUEST_URI ?>about">Το Studio</a></li>
        <li><a href="<?php echo REQUEST_URI ?>program">Πρόγραμμα</a></li>
        <?php $blogEnabled = SettingsHandler::getSettingValueByKey(Setting::BLOG_ENABLED) === 'on';
        if($blogEnabled) { ?>
            <li><a href="<?php echo REQUEST_URI ?>blog">Blog</a></li>
        <?php } ?>
        <li><a href="<?php echo REQUEST_URI ?>contact">Επικοινωνία</a></li>
        <!--<li><a href="#bookNow">Book Now</a></li>-->
    </ul>
    <div class="extraInfo">&copy; 2017 Copyright</div>
</footer>