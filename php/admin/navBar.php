<?php
$loggedInUser = getFullUserFromSession();
$adminRequestUri = getAdminRequestUri();
$adminActionRequestUri = getAdminActionRequestUri();
?>

<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <a class="navbar-brand" href="<?php echo $adminRequestUri . $startPage ?>"><?php echo SITE_TITLE; ?> Admin</a>
        <div class="navbar-brand" style="cursor: default;width: 50px;">
            <img class="img-rounded img-responsive"
                 src="<?php echo ImageUtil::renderUserImage($loggedInUser) ?>"
                 alt="<?php echo $loggedInUser->getUserName() ?>">
        </div>
        <div class="navbar-brand" style="cursor: default;">
            Welcome <?php echo $loggedInUser->getUserName() ?>!
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <a href="<?php echo $adminRequestUri . PageSections::USERS . DS . "updateMyProfile"; ?>">
                            <i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="<?php echo $adminActionRequestUri . "logout" ?>"><i class="fa fa-sign-out fa-fw"></i>
                            Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->
    </div>
    <!-- /.navbar-header -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="<?php echo $adminRequestUri . 'dashboard' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'dashboard') !== false) {
                        echo 'class="active"';
                    } ?>><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <?php if (hasAccess($loggedInUser, AccessRight::USER_SECTION)) { ?>
                    <li>
                        <a href="<?php echo $adminRequestUri . PageSections::USERS . DS . 'users' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'users') !== false) {
                            echo 'class="active"';
                        } ?>><i class="fa fa-users fa-fw"></i> Users</a>
                    </li>
                <?php } ?>
                <?php if (hasAccess($loggedInUser, AccessRight::POSTS_SECTION)) { ?>
                    <li>
                        <a href="<?php echo $adminRequestUri . 'posts' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'posts') !== false) {
                            echo 'class="active"';
                        } ?>><i class="fa fa-comments-o fa-fw"></i> Posts</a>
                    </li>
                <?php } ?>
                <?php if (hasAccess($loggedInUser, AccessRight::PRODUCTS_SECTION)) { ?>
                    <li>
                        <a href="<?php echo $adminRequestUri . 'products' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'products') !== false) {
                            echo 'class="active"';
                        } ?>><i class="fa fa-shopping-cart fa-fw"></i> Products</a>
                    </li>
                <?php } ?>
                <?php if (hasAccess($loggedInUser, AccessRight::PRODUCT_CATEGORIES_SECTION)) { ?>
                    <li>
                        <a href="<?php echo $adminRequestUri . 'productCategories' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'productCategories') !== false) {
                            echo 'class="active"';
                        } ?>><i class="fa fa-list  fa-fw"></i> Product Categories</a>
                    </li>
                <?php } ?>
                <?php if (hasAccess($loggedInUser, AccessRight::PROMOTIONS_SECTION)) { ?>
                    <li>
                        <a href="<?php echo $adminRequestUri . 'promotions' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'promotions') !== false) {
                            echo 'class="active"';
                        } ?>><i class="fa fa-rocket fa-fw"></i> Promotions</a>
                    </li>
                <?php } ?>
                <?php if (hasAccess($loggedInUser, AccessRight::NEWSLETTER_SECTION)) { ?>
                    <li>
                        <a href="<?php echo $adminRequestUri . 'newsletter' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'newsletter') !== false) {
                            echo 'class="active"';
                        } ?>><i class="fa fa-envelope"></i> Newsletter</a>
                    </li>
                <?php } ?>
                <!--<?php if (hasAccess($loggedInUser, AccessRight::PAGES_SECTION)) { ?>
                    <li>
                        <a href="<?php echo $adminRequestUri . 'pages' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'pages') !== false) {
                    echo 'class="active"';
                } ?>><i class="fa fa-table fa-fw"></i> Pages</a>
                    </li>
                <?php } ?>-->
                <?php if (hasAccess($loggedInUser, AccessRight::SETTINGS_SECTION)) { ?>
                    <li>
                        <a href="<?php echo $adminRequestUri . PageSections::SETTINGS . DS . 'settings' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'settings') !== false) {
                            echo 'class="active"';
                        } ?>><i class="fa fa-cog fa-fw"></i> Settings</a>
                    </li>
                <?php } ?>
                <?php if (hasAccess($loggedInUser, AccessRight::PROGRAM_SECTION)) { ?>
                    <li>
                        <a href="<?php echo $adminRequestUri . 'program' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'program') !== false) {
                            echo 'class="active"';
                        } ?>><i class="fa fa-calendar fa-fw"></i> Program</a>
                    </li>
                <?php } ?>
                <?php if (isNotEmpty(DEV_MODE) && DEV_MODE) { ?>
                    <li>
                        <a href="<?php echo $adminRequestUri . 'tables' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'tables') !== false) {
                            echo 'class="active"';
                        } ?>><i class="fa fa-table fa-fw"></i> Tables</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo $adminRequestUri . 'flot' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'flot') !== false) {
                                    echo 'class="active"';
                                } ?>>Flot Charts</a>
                            </li>
                            <li>
                                <a href="<?php echo $adminRequestUri . 'morris' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'morris') !== false) {
                                    echo 'class="active"';
                                } ?>>Morris.js Charts</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="<?php echo $adminRequestUri . 'forms' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'forms') !== false) {
                            echo 'class="active"';
                        } ?>><i class="fa fa-edit fa-fw"></i> Forms</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo $adminRequestUri . 'panelsWells' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'panelsWells') !== false) {
                                    echo 'class="active"';
                                } ?>>Panels and Wells</a>
                            </li>
                            <li>
                                <a href="<?php echo $adminRequestUri . 'buttons' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'buttons') !== false) {
                                    echo 'class="active"';
                                } ?>>Buttons</a>
                            </li>
                            <li>
                                <a href="<?php echo $adminRequestUri . 'notifications' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'notifications') !== false) {
                                    echo 'class="active"';
                                } ?>>Notifications</a>
                            </li>
                            <li>
                                <a href="<?php echo $adminRequestUri . 'typography' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'typography') !== false) {
                                    echo 'class="active"';
                                } ?>>Typography</a>
                            </li>
                            <li>
                                <a href="<?php echo $adminRequestUri . 'icons' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'icons') !== false) {
                                    echo 'class="active"';
                                } ?>> Icons</a>
                            </li>
                            <li>
                                <a href="<?php echo $adminRequestUri . 'grid' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'grid') !== false) {
                                    echo 'class="active"';
                                } ?>>Grid</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Second Level Item</a>
                            </li>
                            <li>
                                <a href="#">Second Level Item</a>
                            </li>
                            <li>
                                <a href="#">Third Level <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo $adminRequestUri . 'blank' ?>" <?php if (strpos(ADMIN_PAGE_ID, 'blank') !== false) {
                                    echo 'class="active"';
                                } ?>>Blank Page</a>
                            </li>
                            <li>
                                <a href="<?php echo $adminRequestUri . 'login' ?>">Login Page</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                <?php } ?>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>