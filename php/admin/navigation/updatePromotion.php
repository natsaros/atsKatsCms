<?php

$promotionId = $_GET["id"];
$isCreate = isEmpty($promotionId);
//TODO server side validation
/*include('validatePromotion.php');*/ ?>

<?php
$loggedInUser = getFullUserFromSession();
if ($isCreate) {
    $currentPromotion = Promotion::create();
} else {
    $currentPromotion = PromotionHandler::getPromotion($promotionId);
}

$pageTitle = $isCreate ? "Create Promotion" : "Update Promotion";

$afterFormSubmission = false;

if (isset($_SESSION['updatePromotionForm']) && !empty($_SESSION['updatePromotionForm'])) {
    $afterFormSubmission = true;
    $form_data = $_SESSION['updatePromotionForm'];
    unset($_SESSION['updatePromotionForm']);
}

$productCategories = ProductCategoryHandler::fetchAllProductCategoriesForAdmin();

//$selectedProductCategoryId = null;
//if($afterFormSubmission) {
//    $selectedProductCategoryId = $form_data[ProductHandler::PRODUCT_CATEGORY_ID];
//} else {
//    $selectedProductCategoryId = $currentProduct->getProductCategoryId();
//}

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
        $promotionUrl = getAdminActionRequestUri() . "promotions";
        $action = $isCreate ? $promotionUrl . DS . "create" : $promotionUrl . DS . "update";
        ?>
        <form name="updatePromotionForm" role="form" action="<?php echo $action ?>" data-toggle="validator" method="post"
              enctype="multipart/form-data">
            <input type="hidden" name="<?php echo PromotionHandler::USER_ID ?>"
                   value="<?php echo $loggedInUser->getID() ?>"/>
            <input type="hidden" name="<?php echo PromotionHandler::ID ?>" value="<?php echo $currentPromotion->getID() ?>"/>

            <div class="form-group">
                <label class="control-label" for="promotedFrom_input">Promoted From *</label>
                <input class="form-control date-field" placeholder="Promoted From"
                       name="<?php echo PromotionHandler::PROMOTED_FROM ?>" id="promotedFrom_input" readonly style="width:auto;"
                       value="<?php if($afterFormSubmission) {?><?=$form_data[PromotionHandler::PROMOTED_FROM]?><?php } else { echo $currentPromotion->getPromotedFrom(); } ?>">
            </div>

            <div class="form-group">
                <label class="control-label" for="promotedTo_input">Promoted To *</label>
                <input class="form-control date-field" placeholder="Promoted To"
                       name="<?php echo PromotionHandler::PROMOTED_TO ?>" id="promotedTo_input" readonly style="width:auto;"
                       value="<?php if($afterFormSubmission) {?><?=$form_data[PromotionHandler::PROMOTED_TO]?><?php } else { echo $currentPromotion->getPromotedTo(); } ?>">
            </div>

            <div class="form-group">
                <label class="control-label" for="promotionText_input">Promotion Text *</label>
                <input class="form-control" placeholder="Promotion Text"
                       name="<?php echo PromotionHandler::PROMOTION_TEXT ?>" id="promotionText_input"
                       value="<?php if($afterFormSubmission) {?><?=$form_data[PromotionHandler::PROMOTION_TEXT]?><?php } else { echo $currentPromotion->getPromotionText(); } ?>">
            </div>

            <div class="form-group">
                <label class="control-label" for="promotedInstanceType_input">Instance Type *</label>
                <select class="form-control" name="<?php echo PromotionHandler::PROMOTED_INSTANCE_TYPE?>" id="promotedInstanceType_input" required
                        value="<?php echo $selectedProductCategoryId;?>">
                    <option value="">Please Select</option>
                    <option value="<?php echo PromotionInstanceType::PRODUCT?>"<?php if((!$afterFormSubmission && $currentPromotion->getPromotedInstanceType() === PromotionInstanceType::PRODUCT) || ($afterFormSubmission && $form_data[PromotionHandler::PROMOTED_INSTANCE_TYPE] === PromotionInstanceType::PRODUCT)) { ?> selected<?php } ?>>Product</option>
                    <option value="<?php echo PromotionInstanceType::PRODUCT_CATEGORY?>"<?php if((!$afterFormSubmission && $currentPromotion->getPromotedInstanceType() === PromotionInstanceType::PRODUCT_CATEGORY) || ($afterFormSubmission && $form_data[PromotionHandler::PROMOTED_INSTANCE_TYPE] === PromotionInstanceType::PRODUCT_CATEGORY)) { ?> selected<?php } ?>>Product Category</option>
                </select>
            </div>

            <div class="text-right form-group">
                <a type="button" href="<?php echo getAdminRequestUri() . 'promotions' ?>"
                   class="btn btn-default">Back</a>
                <input type="submit" name="submit" class="btn btn-primary" value="Save" placeholder="Save"/>
            </div>
        </form>
    </div>
</div>




<!--if ($promoted == 1){-->
<!--if (isEmpty($_POST[ProductHandler::PROMOTED_FROM]) || isEmpty($_POST[ProductHandler::PROMOTED_FROM]) || isEmpty($_POST[ProductHandler::PROMOTION_TEXT])){-->
<!--addErrorMessage("Please fill in required promotion info");-->
<!--}-->
<!--}-->
<!---->
<!--if ($promoted == 1){-->
<!--$promoted_from = date(DEFAULT_DATE_FORMAT, strtotime(str_replace('/', '-', safe_input($_POST[ProductHandler::PROMOTED_FROM]))));-->
<!--$promoted_to = date(DEFAULT_DATE_FORMAT, strtotime(str_replace('/', '-', safe_input($_POST[ProductHandler::PROMOTED_TO]))));-->
<!--$promotion_text = safe_input($_POST[ProductHandler::PROMOTION_TEXT]);-->
<!--$product->setPromoted($promoted)->setPromotedFrom($promoted_from)->setPromotedTo($promoted_to)->setPromotionText($promotion_text)->setPromotionActivation(date(DEFAULT_DATE_FORMAT));-->
<!--} else {-->
<!--$product->setPromoted(0)->setPromotedFrom(null)->setPromotedTo(null)->setPromotionText(null)->setPromotionActivation(null);-->
<!--}
<!--            <div class="form-group">-->
<!--                <label class="control-label" for="productCategoryId_input">Product Category *</label>-->
<!--                <select class="form-control" name="--><?php //echo ProductHandler::PRODUCT_CATEGORY_ID?><!--" id="productCategoryId_input" required-->
<!--                        value="--><?php //echo $selectedProductCategoryId;?><!--">-->
<!--                    <option value="">Please Select</option>-->
<!--                    --><?php
//                    if(!is_null($productCategories) && count($productCategories) > 0) {
//                        foreach ($productCategories as $key => $productCategory){
//                            ?>
<!--                            <option value="--><?php //echo $productCategory->getID()?><!--"--><?php //if((!$afterFormSubmission && $currentPromotion->getProductCategoryId() == $productCategory->getID()) || ($afterFormSubmission && $form_data[ProductHandler::PRODUCT_CATEGORY_ID] == $productCategory->getID())) { ?><!-- selected--><?php //} ?><!-->--><?php //echo $productCategory->getTitle()?><!--</option>-->
<!--                            --><?php
//                        }
//                    }
//                    ?>
<!--                </select>-->
<!--            </div>-->