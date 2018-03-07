<?php
$code = safe_input($_POST[ProductHandler::CODE]);
$title = safe_input($_POST[ProductHandler::TITLE]);
$title_en = safe_input($_POST[ProductHandler::TITLE_EN]);
$description = $_POST[ProductHandler::DESCRIPTION];
$description_en = $_POST[ProductHandler::DESCRIPTION_EN];
$userID = safe_input($_POST[ProductHandler::USER_ID]);
$productCategoryId = safe_input($_POST[ProductHandler::PRODUCT_CATEGORY_ID]);
$secondaryProductCategoryId = safe_input($_POST[ProductHandler::SECONDARY_PRODUCT_CATEGORY_ID]);
$price = $_POST[ProductHandler::PRICE];
$offerPrice = $_POST[ProductHandler::OFFER_PRICE];
$imageValid = true;

$imagePath = safe_input($_POST[ProductHandler::IMAGE_PATH]);

if(isEmpty($description) || isEmpty($description_en) || isEmpty($code) || isEmpty($productCategoryId) || isEmpty($price) || isEmpty($imagePath)) {
    addErrorMessage("Please fill in required info");
}

$image2Upload = $_FILES[ProductHandler::IMAGE];
if($image2Upload['error'] !== UPLOAD_ERR_NO_FILE) {
    $imageValid = ImageUtil::validateImageAllowed($image2Upload);
}

if(isNotEmpty($offerPrice) && floatval($offerPrice) > floatval($price)) {
    addErrorMessage("Offer price cannot be higher than price");
}

if(!$imageValid) {
    addErrorMessage("Please select a valid image file");
}

if(hasErrors()) {
    if (!empty($_POST)) {
        foreach($_POST as $key => $value) {
            $_SESSION['updateProductForm'][$key] = $value;
        }
        $_SESSION['updateProductForm'][$key] = $value;
    }
    Redirect(getAdminRequestUri() . "updateProduct");
}

try {
    $imgContent = !$emptyFile ? ImageUtil::readImageContentFromFile($image2Upload) : false;

    $product2Create = Product::create();
    if (isEmpty($secondaryProductCategoryId)){
        $secondaryProductCategoryId = null;
    }
    $product2Create->setCode($code)->setTitle($title)->setTitleEn($title_en)->setFriendlyTitle(transliterateString(isNotEmpty($title) ? $title : $code))->setUserId($userID)->setDescription($description)->setDescriptionEn($description_en)->setProductCategoryId($productCategoryId)->setSecondaryProductCategoryId($secondaryProductCategoryId)->setPrice($price)->setOfferPrice($offerPrice);

    if($imgContent) {
        //only saving in filesystem for performance reasons
        $product2Create->setImagePath($imagePath);
        //save image content also in blob on db for back up reasons if needed
//        $product2Create->setImagePath($imagePath)->setImage($imgContent);
    }

    $productRes = ProductHandler::createProduct($product2Create);
    if($productRes !== null || $productRes) {
        addSuccessMessage("Product '" . (isNotEmpty($product2Create->getTitle()) ? $product2Create->getTitle() : $product2Create->getCode()) . "' successfully created");
        //save image under id of created product in file system
        if(!$emptyFile) {
            $fileName = basename($image2Upload[ImageUtil::NAME]);
            ImageUtil::saveImageToFileSystem(PRODUCTS_PICTURES_ROOT, $productRes, $fileName, $imgContent);
        }
    } else {
        addErrorMessage("Product '" . (isNotEmpty($product2Create->getTitle()) ? $product2Create->getTitle() : $product2Create->getCode()) . "' failed to be created");
        Redirect(getAdminRequestUri() . "updateProduct");
    }

} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
    Redirect(getAdminRequestUri() . "updateProduct");
}

Redirect(getAdminRequestUri() . "products");
