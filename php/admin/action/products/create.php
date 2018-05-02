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

if(isEmpty($title) || isEmpty($description) || isEmpty($title_en) || isEmpty($description_en) || isEmpty($code) || isEmpty($productCategoryId) || isEmpty($price)) {
    addErrorMessage("Please fill in required info");
}

if(isNotEmpty($offerPrice) && floatval($offerPrice) > floatval($price)) {
    addErrorMessage("Offer price cannot be higher than price");
}

$image2Upload = $_FILES[ProductHandler::IMAGE];
if($image2Upload['error'] !== UPLOAD_ERR_NO_FILE) {
    $imageValid = ImageUtil::validateImageAllowed($image2Upload);
}

if(!$imageValid) {
    addErrorMessage("Please select a valid image file");
}

if (isNotEmpty($title)){
    $productWithSameName = ProductHandler::existProductWithTitle(null, $title_en);
    if($productWithSameName) {
        addErrorMessage("There is a product with the same title");
    }
}

if(hasErrors()) {
    if (!empty($_POST)) {
        foreach($_POST as $key => $value) {
            $_SESSION['updateProductForm'][$key] = $value;
        }
        $_SESSION['updateProductForm'][$key] = $value;
    }
    Redirect(getAdminRequestUri() . PageSections::PRODUCTS . DS . "updateProduct");
}

try {
    $imgContent = !$emptyFile ? ImageUtil::readImageContentFromFile($image2Upload) : false;

    $product2Create = Product::create();
    if (isEmpty($secondaryProductCategoryId)){
        $secondaryProductCategoryId = null;
    }
    $product2Create->setCode($code)->setTitle($title)->setTitleEn($title_en)->setFriendlyTitle(transliterateString($title_en))->setUserId($userID)->setDescription($description)->setDescriptionEn($description_en)->setProductCategoryId($productCategoryId)->setSecondaryProductCategoryId($secondaryProductCategoryId)->setPrice($price)->setOfferPrice($offerPrice);

    if($imgContent) {
        //only saving in filesystem for performance reasons
        $product2Create->setImagePath($imagePath);
        //save image content also in blob on db for back up reasons if needed
//        $product2Create->setImagePath($imagePath)->setImage($imgContent);
    }

    $productRes = ProductHandler::createProduct($product2Create);
    if($productRes !== null || $productRes) {
        addSuccessMessage("Product '" . $product2Create->getTitle() . "' successfully created");
        //save image under id of created product in file system
        if(!$emptyFile) {
            $fileName = basename($image2Upload[ImageUtil::NAME]);
            ImageUtil::saveImageToFileSystem(PRODUCTS_PICTURES_ROOT, $productRes, $fileName, $imgContent);
        }
    } else {
        addErrorMessage("Product '" . $product2Create->getTitle() . "' failed to be created");
        Redirect(getAdminRequestUri() . PageSections::PRODUCTS . DS . "updateProduct");
    }

} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
    Redirect(getAdminRequestUri() . PageSections::PRODUCTS . DS . "updateProduct");
}

Redirect(getAdminRequestUri() . PageSections::PRODUCTS . DS . "products");
