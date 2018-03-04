<?php
$title = safe_input($_POST[ProductCategoryHandler::TITLE]);
$description = $_POST[ProductCategoryHandler::DESCRIPTION];
$userID = safe_input($_POST[ProductCategoryHandler::USER_ID]);

$imageValid = true;
$image2Upload = $_FILES[ProductCategoryHandler::IMAGE];
if($image2Upload['error'] !== UPLOAD_ERR_NO_FILE) {
    $imageValid = ImageUtil::validateImageAllowed($image2Upload);
}

$imagePath = safe_input($_POST[ProductCategoryHandler::IMAGE_PATH]);
$parentCategory = safe_input($_POST[ProductCategoryHandler::PARENT_CATEGORY]);
$parentCategoryId = safe_input($_POST[ProductCategoryHandler::PARENT_CATEGORY_ID]);

if(isEmpty($title) || isEmpty($description)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . "updateProductCategory");
}

if(!$imageValid) {
    addInfoMessage("Please select a valid image file");
    Redirect(getAdminRequestUri() . "updateProductCategory");
}

try {
    $imgContent = !$emptyFile ? ImageUtil::readImageContentFromFile($image2Upload) : false;

    $productCategory2Create = ProductCategory::create();
    if (is_null($parentCategory)){
        $parentCategory = 0;
    }
    $productCategory2Create->setTitle($title)->setFriendlyTitle(transliterateString($title))->setDescription($description)->setUserId($userID)->setParentCategory($parentCategory)->setParentCategoryId($parentCategoryId);

    if($imgContent) {
        //only saving in filesystem for performance reasons
        $productCategory2Create->setImagePath($imagePath);
        //save image content also in blob on db for back up reasons if needed
//        $product2Create->setImagePath($imagePath)->setImage($imgContent);
    }

    $productCategoryRes = ProductCategoryHandler::createProductCategory($productCategory2Create);
    if($productCategoryRes !== null || $productCategoryRes) {
        addSuccessMessage("Product Category '" . $productCategory2Create->getTitle() . "' successfully created");
        //save image under id of created product in file system
        if(!$emptyFile) {
            $fileName = basename($image2Upload[ImageUtil::NAME]);
            ImageUtil::saveImageToFileSystem(PRODUCT_CATEGORIES_PICTURES_ROOT, $productCategoryRes, $fileName, $imgContent);
        }
    } else {
        addErrorMessage("Product Category '" . $productCategory2Create->getTitle() . "' failed to be created");
    }

} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

if(hasErrors()) {
    Redirect(getAdminRequestUri() . "updateProductCategory");
} else {
    Redirect(getAdminRequestUri() . "productCategories");
}