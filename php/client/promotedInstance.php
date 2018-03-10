<?php
$promotion = PromotionHandler::getPromotedInstance();
if ($promotion->getPromotedInstanceType() == PromotionInstanceType::PRODUCT){
    $isPromotedInstanceActive = ($promotion->getPromotedInstance()->getState() == ProductStatus::ACTIVE);
} else if ($promotion->getPromotedInstanceType() == PromotionInstanceType::PRODUCT_CATEGORY){
    $isPromotedInstanceActive = ($promotion->getPromotedInstance()->getState() == ProductCategoryStatus::ACTIVE);
}

if (!is_null($promotion) && $isPromotedInstanceActive){
    if(!isset($_COOKIE["SellinofosPromotion"])) {
        ?>
        <script type="text/javascript">
            $(document).ready(function(){
                showPromotion();
            });
        </script>
        <?php
    } else {
        $promotionId = $_COOKIE["SellinofosPromotion"];
        $promotionIdToCheck = '' . $promotion->getPromotedInstanceType() . '_' . $promotion->getPromotedInstanceId() ;
        if ($promotionId !== $promotionIdToCheck){
            ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    showPromotion();
                });
            </script>
            <?php
        }
    }
}

if (!is_null($promotion) && $isPromotedInstanceActive){
    $promotionId = '' . $promotion->getPromotedInstanceType() . '_' . $promotion->getPromotedInstanceId();
    if ($promotion->getPromotedInstanceType() === PromotionInstanceType::PRODUCT){
        $promotionImageUrl = ImageUtil::renderProductImage($promotion->getPromotedInstance());
        $promotionProductCategory = ProductCategoryHandler::getProductCategoryByID($promotion->getPromotedInstance()->getProductCategoryId());
        $promotionRedirectUrl = PRODUCT_CATEGORIES_URI . $promotionProductCategory->getFriendlyTitle() . DS . $promotion->getPromotedInstance()->getFriendlyTitle();
    } else if ($promotion->getPromotedInstanceType() === PromotionInstanceType::PRODUCT_CATEGORY){
        $promotionImageUrl = ImageUtil::renderProductCategoryImage($promotion->getPromotedInstance());
        $promotionRedirectUrl = PRODUCT_CATEGORIES_URI . $promotion->getPromotedInstance()->getFriendlyTitle();
    }
    ?>
    <div id="promotionInstance">
        <div class="promotion-hide-btn-container">
            <a href="javascript:void(0)" class="promotion-hide-btn" onclick="updatePromotionCookie('<?php echo $promotionId?>', null);">×</a>
        </div>
        <a href="javascript:void(0);" onclick="updatePromotionCookie('<?php echo $promotionId?>', '<?php echo $promotionRedirectUrl?>');">
            <?php if ($promotion->getPromotedInstanceType() !== PromotionInstanceType::PLAIN_TEXT){ ?>
                <div class="promotion-image" style="background: url('<?php echo $promotionImageUrl; ?>') no-repeat center 50% /cover;">
                </div>
            <?php } ?>
            <div class="promotion-text-container">
                <div class="promotion-text">
                    <div class="promotion-text-title">
                        <?php echo $promotion->getPromotedInstance()->getLocalizedTitle()?>
                    </div>
                    <div class="promotion-text-description">
                        <?php echo $promotion->getPromotionText()?>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php
}
?>