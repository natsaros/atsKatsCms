<?php

if (!is_null($productCategory)) {
    $maxPriceFromDB = ProductHandler::fetchMaxProductPrice($productCategory->getID());
    $maxPriceFromDB = ceil($maxPriceFromDB);

    $afterSearch = false;
    if (isset($_GET["minPrice"])){
        $afterSearch = true;
        $minSelectedPrice = safe_input($_GET["minPrice"]);
    } else {
        $minSelectedPrice = 0;
    }
    if (isset($_GET["maxPrice"])){
        $afterSearch = true;
        $maxSelectedPrice = safe_input($_GET["maxPrice"]);
    } else {
        $maxSelectedPrice = $maxPriceFromDB;
    }
    if (isset($_GET["selectedCategory"])){
        $afterSearch = true;
        $selectedCategory = safe_input($_GET["selectedCategory"]);
    } else {
        $selectedCategory = null;
    }

    if (!is_null($selectedCategory)){
        $products = ProductHandler::fetchAllActiveProductsByCriteriaWithDetails($selectedCategory, $minSelectedPrice, $maxSelectedPrice);
    } else {
        $products = ProductHandler::fetchAllActiveProductsByCriteriaWithDetails($productCategory->getID(), $minSelectedPrice, $maxSelectedPrice);
    }
    if ($afterSearch || (!$afterSearch && !is_null($products) && count($products) > 0)) {
        ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $( function() {
                    $("#sliderRange").slider({
                        range: true,
                        min: 0,
                        max: <?php echo $maxPriceFromDB;?>,
                        values: [  <?php echo $minSelectedPrice;?> , <?php echo $maxSelectedPrice;?> ],
                        slide: function(event, ui) {
                            $("#minPrice").val(ui.values[0]);
                            $('#sliderRange .min-value-handler').html(ui.values[0] + "&euro;");
                            $("#maxPrice").val(ui.values[1]);
                            $('#sliderRange .max-value-handler').html(ui.values[1] + "&euro;");
                            $(this).parents().closest('.filter-container').find('.filter-selected-values').html(ui.values[0] + "&euro; - " + ui.values[1] + "&euro;" )
                        },
                        stop: function() {
                            $('#searchProducts').submit();
                        }
                    });
                });

                $( function() {
                    $("#sliderRangeMobile").slider({
                        range: true,
                        min: 0,
                        max: <?php echo $maxPriceFromDB;?>,
                        values: [  <?php echo $minSelectedPrice;?> , <?php echo $maxSelectedPrice;?> ],
                        slide: function(event, ui) {
                            $("#minPrice").val(ui.values[0]);
                            $('#sliderRangeMobile .min-value-handler').html(ui.values[0] + "&euro;");
                            $("#maxPrice").val(ui.values[1]);
                            $('#sliderRangeMobile .max-value-handler').html(ui.values[1] + "&euro;");
                        },
                        stop: function() {
                            $('#searchProducts').submit();
                        }
                    });
                });

                <?php if ($selectedCategory != null) { ?>
                var categoryDesktopElement = $('.filter-select-desktop');
                categoryDesktopElement.val('<?php echo $selectedCategory?>');
                categoryDesktopElement.parents().closest('.filter-container').find('.filter-selected-values').html(categoryDesktopElement.find(":selected").text());
                var categoryMobileElement = $('.filter-select-mobile');
                categoryMobileElement.val('<?php echo $selectedCategory?>');
                <?php } ?>
            });
        </script>

        <div id="filtersSideNav">
            <div class="close-btn-container">
                <a href="javascript:void(0)" class="close-btn" onclick="closeFilters();">×</a>
            </div>
            <?php $childrenProductCategories = $productCategory->getChildrenCategories();
            if(!is_null($childrenProductCategories) && count($childrenProductCategories) > 0) { ?>
                <div class="filter-name-mobile"><?php getLocalizedText('filter_category');?></div>
                <div class="form-group" style="margin-bottom: 0;">
                    <select class="form-control filter-select filter-select-mobile" style="font-size: 13px;width: 78%;margin: 10px auto 27px;border-radius: 0;height: 40px;">
                        <option value=""><?php getLocalizedText('filter_select');?></option>
                        <?php
                        foreach ($childrenProductCategories as $key => $childrenProductCategory){
                            ?>
                            <option value="<?php echo $childrenProductCategory->getID()?>">
                                <?php echo $childrenProductCategory->getLocalizedTitle()?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            <?php } ?>
            <div class="filter-name-mobile"><?php getLocalizedText('filter_price');?></div>
            <div id="sliderRangeMobile" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default min-handler" style="left: 0%;"></span>
                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default max-handler" style="left: 100%;"></span>
                <div class="slider-indicators-container">
                    <div class="min-value-handler"><?php echo $minSelectedPrice . "&euro;";?></div>
                    <div class="max-value-handler"><?php echo $maxSelectedPrice . "&euro;";?></div>
                </div>
                <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
            </div>
        </div>

        <div class="filters desktop">
            <?php $childrenProductCategories = $productCategory->getChildrenCategories();
            if(!is_null($childrenProductCategories) && count($childrenProductCategories) > 0) { ?>
                <div class="filter-container">
                    <div class="filter-header">
                        <div class="filter-name">
                            <?php getLocalizedText('filter_category');?>
                            <span class="filter-selected-values">
                            <?php echo $selectedCategory?>
                        </span>
                        </div>
                        <a href="javascript:void(0);" class="filter-arrow"></a>
                    </div>
                    <div class="filter-body" style="display: none;">
                        <div class="form-group">
                            <select class="form-control filter-select filter-select-desktop">
                                <option value=""><?php getLocalizedText('filter_select');?></option>
                                <?php
                                foreach ($childrenProductCategories as $key => $childrenProductCategory){
                                    ?>
                                    <option value="<?php echo $childrenProductCategory->getID()?>">
                                        <?php echo $childrenProductCategory->getLocalizedTitle()?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="filter-container">
                <div class="filter-header">
                    <div class="filter-name">
                        <?php getLocalizedText('filter_price');?>
                        <span class="filter-selected-values">
                            <?php echo $minSelectedPrice . '&euro;'?> - <?php echo $maxSelectedPrice . '&euro;'?>
                        </span>
                    </div>
                    <a href="javascript:void(0);" class="filter-arrow"></a>
                </div>
                <div class="filter-body" style="display: none;">
                    <div id="sliderRange" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default min-handler" style="left: 0%;"></span>
                        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default max-handler" style="left: 100%;"></span>
                        <div class="slider-indicators-container">
                            <div class="min-value-handler"><?php echo $minSelectedPrice . "&euro;";?></div>
                            <div class="max-value-handler"><?php echo $maxSelectedPrice . "&euro;";?></div>
                        </div>
                        <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                    </div>
                </div>
            </div>
            <?php $action = getClientActionRequestUri() . "searchProducts"; ?>
            <form name="searchProducts" id="searchProducts" role="form" action="<?php echo $action;?>" method="post">
                <input type="hidden" id="minPrice" name="minPrice" value="<?php echo $minSelectedPrice;?>"/>
                <input type="hidden" id="maxPrice" name="maxPrice" value="<?php echo $maxSelectedPrice;?>"/>
                <input type="hidden" name="category" id="category" value="<?php echo $productCategory->getFriendlyTitle();?>"/>
                <input type="hidden" name="selectedCategory" id="selectedCategory" value="<?php echo $selectedCategory;?>"/>
            </form>
        </div>
    <?php } ?>
    <div class="container-fluid text-center productsContainer">
        <?php if ($afterSearch || (!$afterSearch && !is_null($products) && count($products) > 0)) { ?>
            <div class="row row-no-margin filters-icon-container mobile">
                <span onclick="openFilters();" class="filters-icon"></span>
            </div>
        <?php } ?>
        <div class="row row-no-margin">
            <div class="headerTitle">
                <p><?php echo $productCategory->getLocalizedTitle(); ?></p>
            </div>
        </div>
        <div class="row row-no-margin">
            <div class="product-category-description">
                <p><?php echo $productCategory->getLocalizedDescription(); ?></p>
            </div>
        </div>
        <?php if (!is_null($products) && count($products) > 0) {?>
            <div class="row products-row">
                <?php foreach($products as $key => $product) {?>
                    <div class="product-container">
                        <a href="<?php echo getProductCategoriesUri() . $productCategory->getFriendlyTitle() . DS . $product->getFriendlyTitle();?>">
                            <div class="product-image" style="background: url('<?php echo ImageUtil::renderProductImage($product); ?>') no-repeat center 50% /cover;"></div>
                        </a>
                        <div class="product-title">
                            <a href="<?php echo getProductCategoriesUri() . $productCategory->getFriendlyTitle() . DS . $product->getFriendlyTitle();?>">
                                <?php echo $product->getLocalizedTitle(); ?>
                            </a>
                        </div>
                        <?php if (!isEmpty($product->getOfferPrice()) && $product->getOfferPrice() > 0) { ?>
                            <div class="product-initial-price">
                                <?php echo "&euro;" . $product->getPrice(); ?>
                            </div>
                            <div class="product-price">
                                <?php echo "&euro;" . $product->getOfferPrice(); ?>
                            </div>
                        <?php } else if (!isEmpty($product->getPrice()) && $product->getPrice() > 0){ ?>
                            <div class="product-price product-price-no-offer">
                                <?php echo "&euro;" . $product->getPrice(); ?>
                            </div>
                        <?php }?>
                    </div>
                    <?php
                }
                ?>
            </div>
        <?php } else {
            require('noProductsFound.php');
        } ?>
    </div>
<?php } else {
    require('./php/client/404.php');
} ?>
