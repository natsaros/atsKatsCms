<?php

$productCategoryId = $_GET["id"];
$isCreate = isEmpty($productCategoryId);
//TODO server side validation
/*include('validateProductCategory.php');*/ ?>

<?php
$loggedInUser = getFullUserFromSession();
if ($isCreate) {
    $currentProductCategory = ProductCategory::create();
} else {
    $currentProductCategory = ProductCategoryHandler::getProductCategoryByID($productCategoryId);
}
$pageTitle = $isCreate ? "Create Product Category" : "Update Product Category";
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
        $productCategoryUrl = getAdminActionRequestUri() . "productCategories";
        $action = $isCreate ? $productCategoryUrl . DS . "create" : $productCategoryUrl . DS . "update";
        $parentProductCategories = ProductCategoryHandler::fetchAllParentProductCategories();
        ?>
        <form name="updateProductCategoryForm" role="form" action="<?php echo $action ?>" data-toggle="validator" method="post"
              enctype="multipart/form-data">
            <input type="hidden" name="<?php echo ProductCategoryHandler::USER_ID ?>"
                   value="<?php echo $loggedInUser->getID() ?>"/>
            <input type="hidden" name="<?php echo ProductCategoryHandler::STATE ?>"
                   value="<?php echo $currentProductCategory->getState() ?>"/>
            <input type="hidden" name="<?php echo ProductCategoryHandler::ID ?>" value="<?php echo $currentProductCategory->getID() ?>"/>

            <div class="form-group">
                <label class="control-label" for="title_input">Title *</label>
                <input class="form-control" placeholder="Title"
                       name="<?php echo ProductCategoryHandler::TITLE ?>" id="title_input" required
                       value="<?php echo $currentProductCategory->getTitle() ?>"
                >
            </div>

            <div class="form-group">
                <label class="control-label" for="titleEn_input">Title in English *</label>
                <input class="form-control" placeholder="Title in English"
                       name="<?php echo ProductCategoryHandler::TITLE_EN ?>" id="titleEn_input" required
                       value="<?php echo $currentProductCategory->getTitleEn() ?>"
                >
            </div>

            <div class="form-group">
                <label class="control-label" for="uploadImage">Image *</label>
                <div class="form-group input-group">
                    <label class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                    Browse&hellip; <input type="file" style="display: none;" id="uploadImage"
                                          name="<?php echo ProductCategoryHandler::IMAGE ?>"
                                          multiple">
                    </span>
                    </label>
                    <input type="text" value="<?php echo $currentProductCategory->getImagePath(); ?>"
                           name="<?php echo ProductCategoryHandler::IMAGE_PATH ?>" class="form-control hiddenLabel" readonly>
                </div>
            </div>

            <div class="form-group uploadPreview">
                <img data-preview="true" src="<?php echo ImageUtil::renderProductCategoryImage($currentProductCategory); ?>"/>
            </div>

            <div class="form-group">
                <label class="control-label" for="description_input">Description *</label>
                <input class="form-control" placeholder="Description"
                       name="<?php echo ProductCategoryHandler::DESCRIPTION ?>" id="description_input" required
                       value="<?php echo $currentProductCategory->getDescription() ?>"
                >
            </div>

            <div class="form-group">
                <label class="control-label" for="descriptionEn_input">Description in English *</label>
                <input class="form-control" placeholder="Description in English"
                       name="<?php echo ProductCategoryHandler::DESCRIPTION_EN ?>" id="descriptionEn_input" required
                       value="<?php echo $currentProductCategory->getDescriptionEn() ?>"
                >
            </div>

            <div class="form-group">
                <label class="control-label" for="parent_category">Is Parent Category</label>
                <div class="checkbox">
                    <label>
                        <?php $isChecked = $currentProductCategory->getParentCategory() === 1 ? 'checked' : ''?>
                        <input name="<?php echo ProductCategoryHandler::PARENT_CATEGORY; ?>"
                               type="checkbox" <?php echo $isChecked ?>
                               value="<?php echo $currentProductCategory->getParentCategory(); ?>"
                               data-toggle="toggle"
                               id="parent_category"
                               data-custom-on-val="1"
                               data-custom-off-val="0">
                    </label>
                </div>
            </div>

            <div id="parentCategoryIdContainer" class="form-group"<?php if($currentProductCategory->getParentCategory() === 1) { ?> style="visibility: hidden;"<?php } ?>>
                <label class="control-label" for="parentCategoryId_input">Parent Category</label>
                <select class="form-control" name="<?php echo ProductCategoryHandler::PARENT_CATEGORY_ID?>" id="parentCategoryId_input"
                        value="<?php echo $currentProductCategory->getParentCategoryId() ?>">
                    <option value="0">Please Select</option>
                    <?php
                    if(!is_null($parentProductCategories) && count($parentProductCategories) > 0) {
                        foreach ($parentProductCategories as $key => $parentProductCategory){
                            ?>
                            <option value="<?php echo $parentProductCategory->getID()?>"<?php if($currentProductCategory->getParentCategoryId() == $parentProductCategory->getID()) { ?> selected<?php } ?>><?php echo $parentProductCategory->getTitle()?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="text-right form-group">
                <a type="button" href="<?php echo getAdminRequestUri() . 'productCategories' ?>"
                   class="btn btn-default">Back</a>
                <input type="submit" name="submit" class="btn btn-primary" value="Save" placeholder="Save"/>
            </div>
        </form>
    </div>
</div>