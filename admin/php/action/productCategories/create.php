<?php
$title = safe_input($_POST[ProductCategoryHandler::TITLE]);
$title_en = safe_input($_POST[ProductCategoryHandler::TITLE_EN]);
$description = $_POST[ProductCategoryHandler::DESCRIPTION];
$description_en = $_POST[ProductCategoryHandler::DESCRIPTION_EN];
$userID = safe_input($_POST[ProductCategoryHandler::USER_ID]);

$imagePath = safe_input($_POST[ProductCategoryHandler::IMAGE_PATH]);
if (isEmpty($imagePath)) {
    $imagePath = FormHandler::getFormPictureDraftName(ProductCategoryHandler::IMAGE);
}

if (isNotEmpty($imagePath)) {
    $image2Upload = FormHandler::validateUploadedImage(ProductCategoryHandler::IMAGE);
}else{
    addErrorMessage("Please fill in required info");
}

$parentCategory = safe_input($_POST[ProductCategoryHandler::PARENT_CATEGORY]);
$parentCategoryId = safe_input($_POST[ProductCategoryHandler::PARENT_CATEGORY_ID]);

if (isEmpty($title) || isEmpty($title_en)) {
    addErrorMessage("Please fill in required info");
}

if (hasErrors()) {
    FormHandler::setSessionForm('updateProductCategoryForm', $_POST[FormHandler::PAGE_ID]);
    Redirect(getAdminRequestUri() . PageSections::PRODUCT_CATEGORIES . DS . "updateProductCategory");
}

try {
    $imgContent = isNotEmpty($image2Upload) ? ImageUtil::readImageContentFromFile($image2Upload) : false;

    $productCategory2Create = ProductCategory::create();
    if (is_null($parentCategory)) {
        $parentCategory = 0;
    }
    $productCategory2Create->setTitle($title)->setTitleEn($title_en)->setFriendlyTitle(transliterateString($title_en))->setDescription($description)->setDescriptionEn($description_en)->setUserId($userID)->setParentCategory($parentCategory)->setParentCategoryId($parentCategoryId);

    if ($imgContent) {
        //only saving in filesystem for performance reasons
        $productCategory2Create->setImagePath($imagePath);
        //save image content also in blob on db for back up reasons if needed
//        $product2Create->setImagePath($imagePath)->setImage($imgContent);
    }

    $productCategoryRes = ProductCategoryHandler::createProductCategory($productCategory2Create);
    if ($productCategoryRes !== null || $productCategoryRes) {
        addSuccessMessage("Product Category '{$productCategory2Create->getTitle()}' successfully created");
        FormHandler::unsetFormSessionToken();
        //save image under id of created product in file system
        if (isNotEmpty($image2Upload)) {
            $fileName = basename($image2Upload[ImageUtil::NAME]);
            ImageUtil::saveImageToFileSystem(PRODUCT_CATEGORIES_PICTURES_ROOT, $productCategoryRes, $fileName, $imgContent);
        }
    } else {
        addErrorMessage("Product Category '{$productCategory2Create->getTitle()}' failed to be created");
    }

} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

if (hasErrors()) {
    Redirect(getAdminRequestUri() . PageSections::PRODUCT_CATEGORIES . DS . "updateProductCategory");
} else {
    Redirect(getAdminRequestUri() . PageSections::PRODUCT_CATEGORIES . DS . "productCategories");
}