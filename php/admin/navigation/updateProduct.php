<?php

$productId = $_GET["id"];
$isCreate = isEmpty($productId);
//TODO server side validation
/*include('validateProduct.php');*/ ?>

<?php
$loggedInUser = getFullUserFromSession();
if ($isCreate) {
    $currentProduct = Product::create();
} else {
    $currentProduct = ProductHandler::getProductByIDWithDetails($productId);
}

$pageTitle = $isCreate ? "Create Product" : "Update Product";

$afterFormSubmission = false;

if (isset($_SESSION['updateProductForm']) && !empty($_SESSION['updateProductForm'])) {
    $afterFormSubmission = true;
    $form_data = $_SESSION['updateProductForm'];
    unset($_SESSION['updateProductForm']);
}

$productCategories = ProductCategoryHandler::fetchAllActiveProductCategoriesForAdmin();

$selectedProductCategoryId = null;
if($afterFormSubmission) {
    $selectedProductCategoryId = $form_data[ProductHandler::PRODUCT_CATEGORY_ID];
} else {
    $selectedProductCategoryId = $currentProduct->getProductCategoryId();
}

?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $pageTitle; ?>
        </h1>
    </div>
</div>

<?php require("messageSection.php"); ?>

<div class="row">
    <div class="col-lg-12">
        <?php
        $productUrl = getAdminActionRequestUri() . "products";
        $action = $isCreate ? $productUrl . DS . "create" : $productUrl . DS . "update";
        ?>
        <form name="updateProductForm" role="form" action="<?php echo $action ?>" data-toggle="validator" method="post"
              enctype="multipart/form-data">
            <input type="hidden" name="<?php echo ProductHandler::USER_ID ?>"
                   value="<?php echo $loggedInUser->getID() ?>"/>
            <input type="hidden" name="<?php echo ProductHandler::STATE ?>"
                   value="<?php echo $currentProduct->getState() ?>"/>
            <input type="hidden" name="<?php echo ProductHandler::ID ?>" value="<?php echo $currentProduct->getID() ?>"/>
            <div class="form-group">
                <label class="control-label" for="title_input">Title *</label>
                <input class="form-control" placeholder="Title"
                       name="<?php echo ProductHandler::TITLE ?>" id="title_input" required
                       value="<?php if($afterFormSubmission) {?><?=$form_data[ProductHandler::TITLE]?><?php } else { echo $currentProduct->getTitle(); } ?>"
                >
            </div>

            <div class="form-group">
                <label class="control-label" for="uploadImage">Image *</label>
                <div class="form-group input-group">
                    <label class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                    Browse&hellip; <input type="file" style="display: none;" id="uploadImage"
                                          name="<?php echo ProductHandler::IMAGE ?>"
                                          multiple">
                    </span>
                    </label>
                    <input type="text" value="<?php if($afterFormSubmission) {?><?=$form_data[ProductHandler::IMAGE_PATH]?><?php } else { echo $currentProduct->getImagePath(); } ?>"
                           name="<?php echo ProductHandler::IMAGE_PATH ?>" class="form-control hiddenLabel" readonly>
                </div>
            </div>

            <div class="form-group uploadPreview">
                <img data-preview="true" src="<?php echo ImageUtil::renderProductImage($currentProduct); ?>"/>
            </div>

            <div class="form-group">
                <label class="control-label" for="description_input">Description *</label>
                <textarea class="editor" name="<?php echo ProductHandler::DESCRIPTION ?>" id="description_input" required>
                    <?php if($afterFormSubmission) {?><?=$form_data[ProductHandler::DESCRIPTION]?><?php } else { echo $currentProduct->getDescription(); } ?>
                </textarea>
            </div>

            <div class="form-group">
                <label class="control-label" for="productCategoryId_input">Product Category *</label>
                <select class="form-control" name="<?php echo ProductHandler::PRODUCT_CATEGORY_ID?>" id="productCategoryId_input" required
                        value="<?php echo $selectedProductCategoryId;?>">
                    <option value="">Please Select</option>
                    <?php
                    if(!is_null($productCategories) && count($productCategories) > 0) {
                        foreach ($productCategories as $key => $productCategory){
                            ?>
                            <option value="<?php echo $productCategory->getID()?>"<?php if((!$afterFormSubmission && $currentProduct->getProductCategoryId() == $productCategory->getID()) || ($afterFormSubmission && $form_data[ProductHandler::PRODUCT_CATEGORY_ID] == $productCategory->getID())) { ?> selected<?php } ?>><?php echo $productCategory->getTitle()?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label class="control-label" for="secondaryProductCategoryId_input">Secondary Product Category</label>
                <select class="form-control" name="<?php echo ProductHandler::SECONDARY_PRODUCT_CATEGORY_ID?>" id="secondaryProductCategoryId_input"
                        value="<?php if($afterFormSubmission) {?><?=$form_data[ProductHandler::SECONDARY_PRODUCT_CATEGORY_ID]?><?php } else { echo $currentProduct->getSecondaryProductCategoryId(); } ?>">
                    <option value="">Please Select</option>
                    <?php
                    if(!is_null($productCategories) && count($productCategories) > 0) {
                        foreach ($productCategories as $key => $productCategory){
                            if ($selectedProductCategoryId != $productCategory->getID()) {
                                ?>
                                <option value="<?php echo $productCategory->getID()?>"<?php if((!$afterFormSubmission && $currentProduct->getSecondaryProductCategoryId() == $productCategory->getID()) || ($afterFormSubmission && $form_data[ProductHandler::SECONDARY_PRODUCT_CATEGORY_ID] == $productCategory->getID())) { ?> selected<?php } ?>><?php echo $productCategory->getTitle()?></option>
                                <?php
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label class="control-label" for="price_input">Price *</label>
                <input class="form-control numeric" placeholder="Price"
                       name="<?php echo ProductHandler::PRICE ?>" id="price_input" required
                       value="<?php if($afterFormSubmission) {?><?=$form_data[ProductHandler::PRICE]?><?php } else { echo $currentProduct->getPrice(); } ?>">
            </div>

            <div class="form-group">
                <label class="control-label" for="offerPrice_input">Offer Price</label>
                <input class="form-control numeric" placeholder="Offer Price"
                       name="<?php echo ProductHandler::OFFER_PRICE ?>" id="offerPrice_input"
                       value="<?php if($afterFormSubmission) {?><?=$form_data[ProductHandler::OFFER_PRICE]?><?php } else { echo $currentProduct->getOfferPrice(); } ?>">
            </div>

            <div class="form-group">
                <label class="control-label" for="is_promoted">Is Promoted</label>
                <div class="checkbox">
                    <label>
                        <?php $isChecked = $currentProduct->getPromoted() === 1 ? 'checked' : ''?>
                        <input name="<?php echo ProductHandler::PROMOTED; ?>"
                               type="checkbox" <?php echo $isChecked ?>
                               value="<?php echo $currentProduct->getPromoted(); ?>"
                               data-toggle="toggle"
                               id="is_promoted"
                               data-custom-on-val="1"
                               data-custom-off-val="0">
                    </label>
                </div>
            </div>

            <div id="promotedInterval"<?php if($currentProduct->getPromoted() !== 1) { ?> style="display: none;"<?php } ?>>
                <div class="form-group">
                    <label class="control-label" for="promotedFrom_input">Promoted From *</label>
                    <input class="form-control date-field" placeholder="Promoted From"
                           name="<?php echo ProductHandler::PROMOTED_FROM ?>" id="promotedFrom_input" readonly style="width:auto;"
                           value="<?php if($afterFormSubmission) {?><?=$form_data[ProductHandler::PROMOTED_FROM]?><?php } else { echo $currentProduct->getPromotedFrom(); } ?>">
                </div>

                <div class="form-group">
                    <label class="control-label" for="promotedTo_input">Promoted To *</label>
                    <input class="form-control date-field" placeholder="Promoted To"
                           name="<?php echo ProductHandler::PROMOTED_TO ?>" id="promotedTo_input" readonly style="width:auto;"
                           value="<?php if($afterFormSubmission) {?><?=$form_data[ProductHandler::PROMOTED_TO]?><?php } else { echo $currentProduct->getPromotedTo(); } ?>">
                </div>

                <div class="form-group">
                    <label class="control-label" for="promotionText_input">Promotion Text *</label>
                    <input class="form-control" placeholder="Promotion Text"
                           name="<?php echo ProductHandler::PROMOTION_TEXT ?>" id="promotionText_input"
                           value="<?php if($afterFormSubmission) {?><?=$form_data[ProductHandler::PROMOTION_TEXT]?><?php } else { echo $currentProduct->getPromotionText(); } ?>">
                </div>
            </div>

            <div class="text-right form-group">
                <a type="button" href="<?php echo getAdminRequestUri() . 'products' ?>"
                   class="btn btn-default">Back</a>
                <input type="submit" name="submit" class="btn btn-primary" value="Save" placeholder="Save"/>
            </div>
        </form>
    </div>
</div>