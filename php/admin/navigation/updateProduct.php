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

$productCategories = ProductCategoryHandler::fetchAllProductCategoriesForAdmin();

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
                <label class="control-label" for="code_input">Code *</label>
                <input class="form-control" placeholder="Code"
                       name="<?php echo ProductHandler::CODE ?>" id="code_input" required
                       value="<?php if($afterFormSubmission) {?><?=$form_data[ProductHandler::CODE]?><?php } else { echo $currentProduct->getCode(); } ?>"
                >
            </div>

            <div class="form-group">
                <label class="control-label" for="title_input">Title *</label>
                <input class="form-control" placeholder="Title"
                       name="<?php echo ProductHandler::TITLE ?>" id="title_input" required
                       value="<?php if($afterFormSubmission) {?><?=$form_data[ProductHandler::TITLE]?><?php } else { echo $currentProduct->getTitle(); } ?>"
                >
            </div>

            <div class="form-group">
                <label class="control-label" for="titleEn_input">Title in English *</label>
                <input class="form-control" placeholder="Title in English"
                       name="<?php echo ProductHandler::TITLE_EN ?>" id="titleEn_input" required
                       value="<?php if($afterFormSubmission) {?><?=$form_data[ProductHandler::TITLE_EN]?><?php } else { echo $currentProduct->getTitleEn(); } ?>"
                >
            </div>

            <div class="form-group">
                <label class="control-label" for="uploadImage">Image *</label>
                <div class="form-group input-group">
                    <label class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                    Browse&hellip; <input type="file" style="display: none;" id="uploadImage"
                                          name="<?php echo ProductHandler::IMAGE ?>"
                                          multiple>
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
                <label class="control-label" for="descriptionEn_input">Description in English *</label>
                <textarea class="editor" name="<?php echo ProductHandler::DESCRIPTION_EN ?>" id="descriptionEn_input" required>
                    <?php if($afterFormSubmission) {?><?=$form_data[ProductHandler::DESCRIPTION_EN]?><?php } else { echo $currentProduct->getDescriptionEn(); } ?>
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

            <div class="text-right form-group">
                <a type="button" href="<?php echo getAdminRequestUri() . 'products' ?>"
                   class="btn btn-default">Back</a>
                <input type="submit" name="submit" class="btn btn-primary" value="Save" placeholder="Save"/>
            </div>
        </form>
    </div>
</div>