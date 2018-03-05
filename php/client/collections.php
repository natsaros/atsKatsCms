<?php
$productCategories = ProductCategoryHandler::fetchAllActiveParentProductCategories();
?>

<div class="container-fluid text-center productCategoriesContainer">
    <div class="row row-no-margin">
        <div class="headerTitle">
            <p>COLLECTIONS</p>
        </div>
    </div>
    <?php if(!is_null($productCategories) && count($productCategories) > 0) { ?>
        <div class="row product-categories-row">
            <?php
            foreach($productCategories as $key => $pc) {
                ?>
                <div class="product-category-container">
                    <div class="productCategoryImage">
                        <a href="<?php echo getProductCategoriesUri() . $pc->getFriendlyTitle();?>">
                            <div class="product-category-image" style="background: url('<?php echo ImageUtil::renderProductCategoryImage($pc); ?>') no-repeat center 100% /cover;"></div>
                        </a>
                    </div>
                    <div class="productCategoryTitle">
                        <a href="<?php echo getProductCategoriesUri() . $pc->getFriendlyTitle();?>">
                            <?php echo $pc->getLocalizedTitle(); ?>
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    <?php } else {
        require('noProductCategoriesFound.php');
    } ?>
</div>