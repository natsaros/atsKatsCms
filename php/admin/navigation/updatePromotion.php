<!--<div id="promotedInterval"--><?php //if($currentProduct->getPromoted() !== 1) { ?><!-- style="display: none;"--><?php //} ?><!-->-->
<!--    <div class="form-group">-->
<!--        <label class="control-label" for="promotedFrom_input">Promoted From *</label>-->
<!--        <input class="form-control date-field" placeholder="Promoted From"-->
<!--               name="--><?php //echo ProductHandler::PROMOTED_FROM ?><!--" id="promotedFrom_input" readonly style="width:auto;"-->
<!--               value="--><?php //if($afterFormSubmission) {?><!----><?//=$form_data[ProductHandler::PROMOTED_FROM]?><!----><?php //} else { echo $currentProduct->getPromotedFrom(); } ?><!--">-->
<!--    </div>-->
<!---->
<!--    <div class="form-group">-->
<!--        <label class="control-label" for="promotedTo_input">Promoted To *</label>-->
<!--        <input class="form-control date-field" placeholder="Promoted To"-->
<!--               name="--><?php //echo ProductHandler::PROMOTED_TO ?><!--" id="promotedTo_input" readonly style="width:auto;"-->
<!--               value="--><?php //if($afterFormSubmission) {?><!----><?//=$form_data[ProductHandler::PROMOTED_TO]?><!----><?php //} else { echo $currentProduct->getPromotedTo(); } ?><!--">-->
<!--    </div>-->
<!---->
<!--    <div class="form-group">-->
<!--        <label class="control-label" for="promotionText_input">Promotion Text *</label>-->
<!--        <input class="form-control" placeholder="Promotion Text"-->
<!--               name="--><?php //echo ProductHandler::PROMOTION_TEXT ?><!--" id="promotionText_input"-->
<!--               value="--><?php //if($afterFormSubmission) {?><!----><?//=$form_data[ProductHandler::PROMOTION_TEXT]?><!----><?php //} else { echo $currentProduct->getPromotionText(); } ?><!--">-->
<!--    </div>-->
<!--</div>-->


<!--if ($promoted == 1){-->
<!--if (isEmpty($_POST[ProductHandler::PROMOTED_FROM]) || isEmpty($_POST[ProductHandler::PROMOTED_FROM]) || isEmpty($_POST[ProductHandler::PROMOTION_TEXT])){-->
<!--addErrorMessage("Please fill in required promotion info");-->
<!--}-->
<!--}-->
<!---->
<!--if ($promoted == 1){-->
<!--$promoted_from = date(DEFAULT_DATE_FORMAT, strtotime(str_replace('/', '-', safe_input($_POST[ProductHandler::PROMOTED_FROM]))));-->
<!--$promoted_to = date(DEFAULT_DATE_FORMAT, strtotime(str_replace('/', '-', safe_input($_POST[ProductHandler::PROMOTED_TO]))));-->
<!--$promotion_text = safe_input($_POST[ProductHandler::PROMOTION_TEXT]);-->
<!--$product->setPromoted($promoted)->setPromotedFrom($promoted_from)->setPromotedTo($promoted_to)->setPromotionText($promotion_text)->setPromotionActivation(date(DEFAULT_DATE_FORMAT));-->
<!--} else {-->
<!--$product->setPromoted(0)->setPromotedFrom(null)->setPromotedTo(null)->setPromotionText(null)->setPromotionActivation(null);-->
<!--}-->