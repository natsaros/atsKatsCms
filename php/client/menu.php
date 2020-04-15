<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo REQUEST_URI ?>home">
                <img src="<?php echo ASSETS_URI ?>img/logo.png" alt="Fitness House" class="img-responsive">
            </a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li class="<?php if($pageId == "home") { ?>active<?php } ?>"><a href="<?php echo REQUEST_URI ?>home">Αρχική</a>
                </li>
                <li class="<?php if($pageId == "about") { ?>active<?php } ?>"><a href="<?php echo REQUEST_URI ?>about">Το
                        Studio</a></li>
                <li class="<?php if($pageId == "program") { ?>active<?php } ?>"><a
                            href="<?php echo REQUEST_URI ?>program">Πρόγραμμα</a></li>
                <?php $blogEnabled = SettingsHandler::getSettingValueByKey(Setting::BLOG_ENABLED) === 'on';
                if($blogEnabled) { ?>
                    <li class="<?php if($pageId == "blog" || $pageId == "blogpost") { ?>active<?php } ?>"><a
                                href="<?php echo REQUEST_URI ?>blog">Blog</a></li>
                <?php } ?>
                <li class="<?php if($pageId == "online_courses") { ?>active<?php } ?>"><a
                            href="<?php echo REQUEST_URI ?>online_courses">Γυμνάσου τώρα</a></li>
                <li class="<?php if($pageId == "contact") { ?>active<?php } ?>"><a
                            href="<?php echo REQUEST_URI ?>contact">Επικοινωνία</a></li>
            </ul>
        </div>
    </div>
</nav>