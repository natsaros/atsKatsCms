<?php
$id = $_GET['id'];

if (isEmpty($id)) {
    addInfoMessage("Choose promotion to delete");
    Redirect(getAdminRequestUri() . PageSections::PROMOTIONS . DS . "promotions");
}

try {
    $promotion2delete = PromotionHandler::getPromotion($id);
    if (isNotEmpty($promotion2delete)) {
        $deletePromotionRes = PromotionHandler::deletePromotion($id);
    } else {
        addInfoMessage(ErrorMessages::WENT_WRONG);
    }
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

Redirect(getAdminRequestUri() . PageSections::PROMOTIONS . DS . "promotions");