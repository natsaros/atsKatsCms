<?php
$promotedProduct = ProductHandler::getPromotedProduct();
if (!is_null($promotedProduct)){
    $promotedProductCategory = ProductCategoryHandler::getProductCategoryByID($promotedProduct->getProductCategoryId());
    if(!isset($_COOKIE["SellinofosPromotedProduct"])) {
        ?>
        <script type="text/javascript">
            $(document).ready(function(){
                showPromotedProduct();
            });
        </script>
        <?php
    } else {
        $promotedProductId = $_COOKIE["SellinofosPromotedProduct"];
        if ($promotedProductId != $promotedProduct->getID()){
            ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    showPromotedProduct();
                });
            </script>
            <?php
        }
    }
}

if (!is_null($promotedProduct)){
    ?>
    <div id="promotedProduct">
        <input type="hidden" value="<?php echo $promotedProduct->getID()?>" id="promotedProductId"/>
        <div class="promoted-product-hide-btn-container">
            <a href="javascript:void(0)" class="promoted-product-hide-btn" onclick="updatePromotedProductCookie(<?php echo $promotedProduct->getID()?>, null);">×</a>
        </div>
        <a href="javascript:void(0);" onclick="updatePromotedProductCookie(<?php echo $promotedProduct->getID()?>, '<?php echo PRODUCT_CATEGORIES_URI . $promotedProductCategory->getFriendlyTitle() . DS . $promotedProduct->getFriendlyTitle()?>');">
        <div class="promoted-product-image" style="background: url('<?php echo ImageUtil::renderProductImage($promotedProduct); ?>') no-repeat center 100% /cover;">
        </div>
        <div class="promoted-product-text-container">
            <div class="promoted-product-text">
                <div class="promoted-product-text-title">
                    <?php echo $promotedProduct->getTitle()?>
                </div>
                <div class="promoted-product-text-description">
                    <?php echo $promotedProduct->getPromotionText()?>
                </div>
            </div>
        </div>
        </a>
    </div>
    <?php
}
?>