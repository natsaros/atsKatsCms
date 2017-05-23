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

        <?php $startPage = isNotEmpty(DEV_MODE) && DEV_MODE ? 'dashboard' : 'users'; ?>
        <a class="navbar-brand" href="<?php echo $adminRequestUri . $startPage ?>">Fitness House Admin</a>
        <div class="navbar-brand" style="cursor: default;width: 50px;">
            <img class="img-rounded img-responsive"
                 src="<?php echo ImageUtil::renderUserImage($loggedInUser->getPicture()) ?>"
                 alt="<?php echo $loggedInUser->getUserName() ?>">
        </div>
        <div class="navbar-brand" style="cursor: default;">
            Welcome <?php echo $loggedInUser->getUserName() ?>
        </div>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-messages">
                <li>
                    <a href="#">
                        <div>
                            <strong>John Smith</strong>
                            <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                        </div>
                        <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <strong>John Smith</strong>
                            <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                        </div>
                        <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <strong>John Smith</strong>
                            <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                        </div>
                        <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="text-center" href="#">
                        <strong>Read All Messages</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-messages -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-tasks">
                <li>
                    <a href="#">
                        <div>
                            <p>
                                <strong>Task 1</strong>
                                <span class="pull-right text-muted">40% Complete</span>
                            </p>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <p>
                                <strong>Task 2</strong>
                                <span class="pull-right text-muted">20% Complete</span>
                            </p>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                    <span class="sr-only">20% Complete</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <p>
                                <strong>Task 3</strong>
                                <span class="pull-right text-muted">60% Complete</span>
                            </p>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                    <span class="sr-only">60% Complete (warning)</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <p>
                                <strong>Task 4</strong>
                                <span class="pull-right text-muted">80% Complete</span>
                            </p>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                    <span class="sr-only">80% Complete (danger)</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="text-center" href="#">
                        <strong>See All Tasks</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-tasks -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-comment fa-fw"></i> New Comment
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                            <span class="pull-right text-muted small">12 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-envelope fa-fw"></i> Message Sent
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-tasks fa-fw"></i> New Task
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-upload fa-fw"></i> Server Rebooted
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="text-center" href="#">
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-alerts -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                    <a href="<?php echo $adminRequestUri . "updateUser" . addParamsToUrl(array('id'), array($loggedInUser->getID())); ?>">
                        <i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li><a href="<?php echo $adminActionRequestUri ?>logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <?php if(isNotEmpty(DEV_MODE) && DEV_MODE) { ?>
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <!-- /input-group -->
                    </li>
                    <li>
                        <a href="<?php echo $adminRequestUri . 'dashboard' ?>" <?php if(strpos(ADMIN_PAGE_ID, 'dashboard') !== false) {
                            echo 'class="active"';
                        } ?>><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                <?php } ?>
                <li>
                    <a href="<?php echo $adminRequestUri . 'users' ?>" <?php if(strpos(ADMIN_PAGE_ID, 'users') !== false) {
                        echo 'class="active"';
                    } ?>><i class="fa fa-users fa-fw"></i> Users</a>
                </li>
                <li>
                    <a href="<?php echo $adminRequestUri . 'posts' ?>" <?php if(strpos(ADMIN_PAGE_ID, 'posts') !== false) {
                        echo 'class="active"';
                    } ?>><i class="fa fa-comments-o fa-fw"></i> Posts</a>
                </li>
                <?php if(isNotEmpty(DEV_MODE) && DEV_MODE) { ?>
                    <li>
                        <a href="<?php echo $adminRequestUri . 'pages' ?>" <?php if(strpos(ADMIN_PAGE_ID, 'pages') !== false) {
                            echo 'class="active"';
                        } ?>><i class="fa fa-table fa-fw"></i> Pages</a>
                    </li>
                    <li>
                        <a href="<?php echo $adminRequestUri . 'tables' ?>" <?php if(strpos(ADMIN_PAGE_ID, 'tables') !== false) {
                            echo 'class="active"';
                        } ?>><i class="fa fa-table fa-fw"></i> Tables</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo $adminRequestUri . 'flot' ?>" <?php if(strpos(ADMIN_PAGE_ID, 'flot') !== false) {
                                    echo 'class="active"';
                                } ?>>Flot Charts</a>
                            </li>
                            <li>
                                <a href="<?php echo $adminRequestUri . 'morris' ?>" <?php if(strpos(ADMIN_PAGE_ID, 'morris') !== false) {
                                    echo 'class="active"';
                                } ?>>Morris.js Charts</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="<?php echo $adminRequestUri . 'forms' ?>" <?php if(strpos(ADMIN_PAGE_ID, 'forms') !== false) {
                            echo 'class="active"';
                        } ?>><i class="fa fa-edit fa-fw"></i> Forms</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo $adminRequestUri . 'panelsWells' ?>" <?php if(strpos(ADMIN_PAGE_ID, 'panelsWells') !== false) {
                                    echo 'class="active"';
                                } ?>>Panels and Wells</a>
                            </li>
                            <li>
                                <a href="<?php echo $adminRequestUri . 'buttons' ?>" <?php if(strpos(ADMIN_PAGE_ID, 'buttons') !== false) {
                                    echo 'class="active"';
                                } ?>>Buttons</a>
                            </li>
                            <li>
                                <a href="<?php echo $adminRequestUri . 'notifications' ?>" <?php if(strpos(ADMIN_PAGE_ID, 'notifications') !== false) {
                                    echo 'class="active"';
                                } ?>>Notifications</a>
                            </li>
                            <li>
                                <a href="<?php echo $adminRequestUri . 'typography' ?>" <?php if(strpos(ADMIN_PAGE_ID, 'typography') !== false) {
                                    echo 'class="active"';
                                } ?>>Typography</a>
                            </li>
                            <li>
                                <a href="<?php echo $adminRequestUri . 'icons' ?>" <?php if(strpos(ADMIN_PAGE_ID, 'icons') !== false) {
                                    echo 'class="active"';
                                } ?>> Icons</a>
                            </li>
                            <li>
                                <a href="<?php echo $adminRequestUri . 'grid' ?>" <?php if(strpos(ADMIN_PAGE_ID, 'grid') !== false) {
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
                                <a href="<?php echo $adminRequestUri . 'blank' ?>" <?php if(strpos(ADMIN_PAGE_ID, 'blank') !== false) {
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