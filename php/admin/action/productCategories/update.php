<?php
$ID = safe_input($_POST[ProductCategoryHandler::ID]);
$title = safe_input($_POST[ProductCategoryHandler::TITLE]);
$title_en = safe_input($_POST[ProductCategoryHandler::TITLE_EN]);
$description = $_POST[ProductCategoryHandler::DESCRIPTION];
$description_en = $_POST[ProductCategoryHandler::DESCRIPTION_EN];

$state = safe_input($_POST[ProductCategoryHandler::STATE]);
$userID = safe_input($_POST[ProductCategoryHandler::USER_ID]);

$imageValid = true;
$image2Upload = $_FILES[ProductCategoryHandler::IMAGE];
$parentCategory = safe_input($_POST[ProductCategoryHandler::PARENT_CATEGORY]);
$parentCategoryId = safe_input($_POST[ProductCategoryHandler::PARENT_CATEGORY_ID]);

$emptyFile = $image2Upload['error'] === UPLOAD_ERR_NO_FILE;
if(!$emptyFile) {
    $imageValid = ImageUtil::validateImageAllowed($image2Upload);
}

$imagePath = safe_input($_POST[ProductCategoryHandler::IMAGE_PATH]);

if(isEmpty($title) || isEmpty($description) || isEmpty($title_en) || isEmpty($description_en)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . "productCategories");
}

if(!$imageValid) {
    addInfoMessage("Please select a valid image file");
    Redirect(getAdminRequestUri() . "updateProductCategory" . addParamsToUrl(array('id'), array($ID)));
}

try {
    $imgContent = !$emptyFile ? ImageUtil::readImageContentFromFile($image2Upload) : false;

    //Get product category from db to edit
    $productCategory = ProductCategoryHandler::getProductCategoryByID($ID);
    if (is_null($parentCategory)){
        $parentCategory = 0;
    }
    $productCategory->setTitle($title)->setTitleEn($title_en)->setFriendlyTitle(transliterateString($title_en))->setState($state)->setUserId($userID)->setDescription($description)->setDescriptionEn($description_en)->setParentCategory($parentCategory)->setParentCategoryId($parentCategoryId);

    if($imgContent) {
        //only saving in filesystem for performance reasons
        $productCategory->setImagePath($imagePath);

        //save image content also in blob on db for back up reasons if needed
//        $productCategory->setImagePath($imagePath)->setImage($imgContent);
    }

    $productCategoryRes = ProductCategoryHandler::update($productCategory);
    if($productCategoryRes !== null || $productCategoryRes) {
        addSuccessMessage("Product category '" . $productCategory->getTitle() . "' successfully updated");
        //save image under id of created product category in file system
        if(!$emptyFile) {
            $fileName = basename($image2Upload[ImageUtil::NAME]);
            ImageUtil::saveImageToFileSystem(PRODUCT_CATEGORIES_PICTURES_ROOT, $ID, $fileName, $imgContent);
        }
    } else {
        addErrorMessage("Product category '" . $productCategory->getTitle() . "' failed to be updated");
    }

} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

if(hasErrors()) {
    Redirect(getAdminRequestUri() . "updateProductCategory" . addParamsToUrl(array('id'), array($ID)));
} else {
    Redirect(getAdminRequestUri() . "productCategories");
}