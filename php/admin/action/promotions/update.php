<?php
$ID = safe_input($_POST[PromotionHandler::ID]);
$promoted_from = date(DEFAULT_DATE_FORMAT, strtotime(str_replace('/', '-', safe_input($_POST[PromotionHandler::PROMOTED_FROM]))));
$promoted_to = date(DEFAULT_DATE_FORMAT, strtotime(str_replace('/', '-', safe_input($_POST[PromotionHandler::PROMOTED_TO]))));
$promotion_text = safe_input($_POST[PromotionHandler::PROMOTION_TEXT]);
$promotion_instance_type = safe_input($_POST[PromotionHandler::PROMOTED_INSTANCE_TYPE]);
$promotion_instance_id = safe_input($_POST[PromotionHandler::PROMOTED_INSTANCE_ID]);
$userID = safe_input($_POST[ProductHandler::USER_ID]);

if (isEmpty($promoted_from) || isEmpty($promoted_to) || isEmpty($promotion_text) || isEmpty($promotion_instance_type) || (isNotEmpty($promotion_instance_type) && $promotion_instance_type != PromotionInstanceType::PLAIN_TEXT && isEmpty($promotion_instance_id))){
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
    $promotion2Update = PromotionHandler::getPromotion($ID);
    if (isEmpty($promotion_instance_id)){
        $promotion_instance_id = null;
    }
    $promotion2Update->setPromotedFrom($promoted_from)->setPromotedTo($promoted_to)->setPromotionText($promotion_text)->setPromotionActivation(date(DEFAULT_DATE_FORMAT))->setPromotedInstanceType($promotion_instance_type)->setPromotedInstanceId($promotion_instance_id)->setUserId($userID);
    $promotionRes = PromotionHandler::update($promotion2Update);
    if($promotionRes !== null || $promotionRes) {
        addSuccessMessage("Promotion with ID successfully updated");
    } else {
        addErrorMessage("Promotion failed to be updated");
        Redirect(getAdminRequestUri() . "updatePromotion");
    }

} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
    Redirect(getAdminRequestUri() . "updatePromotion");
}

Redirect(getAdminRequestUri() . "promotions");