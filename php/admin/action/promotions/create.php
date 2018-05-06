<?php
$promoted_from = date(DEFAULT_DATE_FORMAT, strtotime(str_replace('/', '-', safe_input($_POST[PromotionHandler::PROMOTED_FROM]))));
$promoted_to = date(DEFAULT_DATE_FORMAT, strtotime(str_replace('/', '-', safe_input($_POST[PromotionHandler::PROMOTED_TO]))));
$promotion_text = safe_input($_POST[PromotionHandler::PROMOTION_TEXT]);
$promotion_text_en = safe_input($_POST[PromotionHandler::PROMOTION_TEXT_EN]);
$promotion_instance_type = safe_input($_POST[PromotionHandler::PROMOTED_INSTANCE_TYPE]);
$promotion_instance_id = safe_input($_POST[PromotionHandler::PROMOTED_INSTANCE_ID]);
$promotion_link = safe_input($_POST[PromotionHandler::PROMOTION_LINK]);
$userID = safe_input($_POST[PromotionHandler::USER_ID]);

if (isEmpty($promoted_from) || isEmpty($promoted_to) || isEmpty($promotion_text) || isEmpty($promotion_text_en) || isEmpty($promotion_instance_type) || (isNotEmpty($promotion_instance_type) && $promotion_instance_type != PromotionInstanceType::PLAIN_TEXT && isEmpty($promotion_instance_id)) || (isNotEmpty($promotion_instance_type) && $promotion_instance_type == PromotionInstanceType::PLAIN_TEXT && isEmpty($promotion_link))){
    addErrorMessage("Please fill in required info");
}

if(hasErrors()) {
    FormHandler::setSessionForm('updatePromotionForm');
    Redirect(getAdminRequestUri() . PageSections::PROMOTIONS . DS . "updatePromotion");
}

try {
    $promotion2Create = Promotion::create();
    if (isEmpty($promotion_instance_id)){
        $promotion_instance_id = null;
    }
    $promotion2Create->setPromotedFrom($promoted_from)->
    setPromotedTo($promoted_to)->
    setPromotionText($promotion_text)->
    setPromotionTextEn($promotion_text_en)->
    setPromotionActivation(date(DEFAULT_DATE_FORMAT))->
    setPromotedInstanceType($promotion_instance_type)->
    setPromotedInstanceId($promotion_instance_id)->
    setPromotionLink($promotion_link)->setUserId($userID);

    $promotionRes = PromotionHandler::insertPromotion($promotion2Create);
    if($promotionRes !== null || $promotionRes) {
        addSuccessMessage("Promotion successfully created");
    } else {
        addErrorMessage("Promotion failed to be created");
        Redirect(getAdminRequestUri() . PageSections::PROMOTIONS . DS . "updatePromotion");
    }

} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
    Redirect(getAdminRequestUri() . PageSections::PROMOTIONS . DS . "updatePromotion");
}

Redirect(getAdminRequestUri() . PageSections::PROMOTIONS . DS . "promotions");