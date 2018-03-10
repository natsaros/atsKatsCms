<?php
$promoted_from = date(DEFAULT_DATE_FORMAT, strtotime(str_replace('/', '-', safe_input($_POST[PromotionHandler::PROMOTED_FROM]))));
$promoted_to = date(DEFAULT_DATE_FORMAT, strtotime(str_replace('/', '-', safe_input($_POST[PromotionHandler::PROMOTED_TO]))));
$promotion_text = safe_input($_POST[PromotionHandler::PROMOTION_TEXT]);
$promotion_instance_type = safe_input($_POST[PromotionHandler::PROMOTED_INSTANCE_TYPE]);
$promotion_instance_id = safe_input($_POST[PromotionHandler::PROMOTED_INSTANCE_ID]);
$userID = safe_input($_POST[ProductHandler::USER_ID]);

if (isEmpty($promoted_from) || isEmpty($promoted_to) || isEmpty($promotion_text) || isEmpty($promotion_instance_type) || isEmpty($promotion_instance_id)){
    addErrorMessage("Please fill in required info");
}

if(hasErrors()) {
    if (!empty($_POST)) {
        foreach($_POST as $key => $value) {
            $_SESSION['updatePromotionForm'][$key] = $value;
        }
        $_SESSION['updatePromotionForm'][$key] = $value;
    }
    Redirect(getAdminRequestUri() . "updatePromotion");
}

try {
    $promotion2Create = Promotion::create();
    $promotion2Create->setPromotedFrom($promoted_from)->setPromotedTo($promoted_to)->setPromotionText($promotion_text)->setPromotionActivation(date(DEFAULT_DATE_FORMAT))->setPromotedInstanceType($promotion_instance_type)->setPromotedInstanceId($promotion_instance_id)->setUserId($userID);
    $promotionRes = PromotionHandler::insertPromotion($promotion2Create);
    if($promotionRes !== null || $promotionRes) {
        addSuccessMessage("Promotion successfully created");
    } else {
        addErrorMessage("Promotion failed to be created");
        Redirect(getAdminRequestUri() . "updatePromotion");
    }

} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
    Redirect(getAdminRequestUri() . "updatePromotion");
}

Redirect(getAdminRequestUri() . "promotions");