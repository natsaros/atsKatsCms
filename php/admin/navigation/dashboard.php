<?php
$loggedInUser = getFullUserFromSession();
?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
    </div>

<?php require("messageSection.php"); ?>

    <div class="row">
        <?php if ($pageSections->hasAccessToPageSection(PageSections::NEWSLETTER, $loggedInUser->getAccessRightsStr())) { ?>
            <div class="col-lg-6 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-2">
                                <i class="fa fa-envelope fa-4x"></i>
                            </div>
                            <div class="col-xs-10 text-right">
                                <?php $latestNewsletterSubscriptions = NewsletterHandler::getLatestNewsletterSubscriptions();
                                $newsletterSubscriptionMessage = 'Newsletter' . (($latestNewsletterSubscriptions == 1) ? ' subscription ' : ' subscriptions ') . 'the last 3 Days'; ?>
                                <div class="huge">
                                    <?php echo $latestNewsletterSubscriptions; ?>
                                </div>
                                <div>
                                    <?php echo $newsletterSubscriptionMessage; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo getAdminRequestUri() . PageSections::NEWSLETTER . DS . 'newsletter'; ?>">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
        <?php if ($pageSections->hasAccessToPageSection(PageSections::PROMOTIONS, $loggedInUser->getAccessRightsStr())) { ?>
            <?php $activePromotion = PromotionHandler::getPromotedInstance();
            if (!is_null($activePromotion)) {
                if ($activePromotion->getPromotedInstanceType() == PromotionInstanceType::PRODUCT) {
                    $isPromotedInstanceActive = (!is_null($activePromotion->getPromotedInstance()) && $activePromotion->getPromotedInstance()->getState() == ProductStatus::ACTIVE);
                } else if ($activePromotion->getPromotedInstanceType() == PromotionInstanceType::PRODUCT_CATEGORY) {
                    $isPromotedInstanceActive = (!is_null($activePromotion->getPromotedInstance()) && $activePromotion->getPromotedInstance()->getState() == ProductCategoryStatus::ACTIVE);
                } else if ($activePromotion->getPromotedInstanceType() == PromotionInstanceType::PLAIN_TEXT) {
                    $isPromotedInstanceActive = true;
                }
            }
            if (!is_null($activePromotion) && $isPromotedInstanceActive) {
                $timesSeen = $activePromotion->getTimesSeen();
                $activePromotionMessage = 'Views for Promotion';
                $activePromotionMessage .= ' with Promotion Text \'' . $activePromotion->getPromotionText() . '\'';
            } else {
                $timesSeen = '&nbsp;';
                $activePromotionMessage = 'There are no Active Promotions';
            }
            ?>
            <div class="col-lg-6 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-2">
                                <i class="fa fa-rocket fa-4x"></i>
                            </div>
                            <div class="col-xs-10 text-right">
                                <div class="huge">
                                    <?php echo $timesSeen; ?>
                                </div>
                                <div>
                                    <?php echo $activePromotionMessage; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo getAdminRequestUri() . PageSections::PROMOTIONS . DS . 'promotions'; ?>">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>

<?php if (isNotEmpty(GA_OATH_CLIENT_ID)) { ?>
    <div id="GA-stats">
        <div class="row">
            <div class="col-sm-12">
                <div id="view-selector-container"></div>
                <div id="view-name"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div id="active-users-container"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 chart-container">
                <div class="Chartjs">
                    <h3>Last 30 Days</h3>
                    <figure class="Chartjs-figure" id="chart-1-container"></figure>
                    <ol class="Chartjs-legend" id="legend-1-container"></ol>
                </div>
            </div>
            <div class="col-md-12 chart-container">
                <div class="Chartjs">
                    <h3>This Week Session vs Last Week Sessions</h3>
                    <figure class="Chartjs-figure" id="chart-2-container"></figure>
                    <ol class="Chartjs-legend" id="legend-2-container"></ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 chart-container">
                <div class="Chartjs">
                    <h3>Sessions by device</h3>
                    <figure class="Chartjs-figure" id="chart-3-container"></figure>
                    <ol class="Chartjs-legend" id="legend-3-container"></ol>
                </div>
            </div>
            <div class="col-sm-6 chart-container">
                <div class="Chartjs">
                    <h3>Sessions by country</h3>
                    <figure class="Chartjs-figure" id="chart-4-container"></figure>
                    <ol class="Chartjs-legend" id="legend-4-container"></ol>
                </div>
            </div>
        </div>
    </div>
<?php } ?>