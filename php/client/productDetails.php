<?php if (!is_null($productCategory)) {
    if (isset($_GET["product_friendly_url"])) {
        $product = ProductHandler::getProductByFriendlyTitleWithDetails($_GET["product_friendly_url"]);
    } else {
        $product = null;
    }
    if (!is_null($product)) {
        ?>
        <div class="container-fluid text-center productContainer">
            <div class="row row-no-margin">
                <div class="col-sm-6">
                    <div class="product-details-image" style="background: url('<?php echo ImageUtil::renderProductImage($product); ?>') no-repeat center 100% /cover;">
                    </div>
                </div>
                <div class="col-sm-6 product-details-info">
                    <div class="product-details-title">
                        <?php echo $product->getLocalizedTitle(); ?>
                    </div>
                    <div class="product-details-code">
                        <?php echo getLocalizedText("product_code");?><?php echo $product->getCode(); ?>
                    </div>
                    <div class="product-details-category">
                        <?php echo $productCategory->getLocalizedTitle(); ?>
                    </div>
                    <div class="product-details-description">
                        <?php echo $product->getLocalizedDescription();?>
                    </div>
                    <?php if (!isEmpty($product->getOfferPrice()) && $product->getOfferPrice() > 0) { ?>
                        <div class="product-details-initial-price">
                            <?php echo "&euro;" . $product->getPrice(); ?>
                        </div>
                        <div class="product-details-price">
                            <?php echo "&euro;" . $product->getOfferPrice(); ?>
                        </div>
                    <?php } else if (!isEmpty($product->getPrice()) && $product->getPrice() > 0){ ?>
                        <div class="product-details-price">
                            <?php echo "&euro;" . $product->getPrice(); ?>
                        </div>
                    <?php }?>
                </div>
            </div>

        </div>
    <?php } else {
        require('404.php');
    }
} else {
    require('404.php');
} ?>