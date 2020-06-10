<?php
$id = $_POST["id"];

if (isNotEmpty($id)){
    PromotionHandler::updateTimesSeen($id);
}
