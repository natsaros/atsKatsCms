<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <h3 class="active-promotion-header">Active Promotion</h3>
    </div>
</div>
<?php $activePromotion = PromotionHandler::getPromotedInstance();
if (!is_null($promotion)) {
    if ($activePromotion->getPromotedInstanceType() == PromotionInstanceType::PRODUCT) {
        $isPromotedInstanceActive = (!is_null($activePromotion->getPromotedInstance()) && $activePromotion->getPromotedInstance()->getState() == ProductStatus::ACTIVE);
    } else if ($activePromotion->getPromotedInstanceType() == PromotionInstanceType::PRODUCT_CATEGORY) {
        $isPromotedInstanceActive = (!is_null($activePromotion->getPromotedInstance()) && $activePromotion->getPromotedInstance()->getState() == ProductCategoryStatus::ACTIVE);
    } else if ($activePromotion->getPromotedInstanceType() == PromotionInstanceType::PLAIN_TEXT) {
        $isPromotedInstanceActive = true;
    }
}
if (!is_null($activePromotion) && $isPromotedInstanceActive) { ?>
    <div class="row dashboard-active-promotion">
        <div class="col-sm-12">
            <?php echo 'The promotion';?>
            <?php if ($activePromotion->getPromotedInstanceType() == PromotionInstanceType::PRODUCT_CATEGORY) { echo ' for category '; } else if ($activePromotion->getPromotedInstanceType() == PromotionInstanceType::PRODUCT) { echo ' for product '; } ?>
            <?php if ($activePromotion->getPromotedInstanceType() == PromotionInstanceType::PRODUCT_CATEGORY || $activePromotion->getPromotedInstanceType() == PromotionInstanceType::PRODUCT) { echo ' <b>' . $activePromotion->getPromotedInstance()->getTitle() . '</b> '; }?>
            <?php echo ' with promotion text \'' . $activePromotion->getPromotionText() . '\'';?>
            <?php echo ' is active until ' . $activePromotion->getPromotedTo() . '.<br/>';?>
            <?php echo 'So far it has been seen <b>' . $activePromotion->getTimesSeen() . '</b> times.';?>
        </div>
    </div>
<?php } else { ?>
    <div class="row dashboard-active-promotion">
        <div class="col-sm-12">
            <?php echo 'There are no active promotions.';?>
        </div>
    </div>
<?php }  ?>

