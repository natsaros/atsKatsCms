<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'visitors' . DS . 'Visitor.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'visitors' . DS . 'VisitorStatus.php');
require_once(CLASSES_ROOT_PATH . 'db' . DS . 'VisitorHandler.php');

try{
    $fbAccessToken = $_POST['fbAccessToken'];

    $fbInfo = file_get_contents("https://graph.facebook.com/v2.8/me?fields=id%2Cfirst_name%2Clast_name%2Cemail%2Cpicture.type%28large%29&access_token=" . $fbAccessToken);
    $visitor2Insert = Visitor::create();

    $jsonArray = json_decode($fbInfo, true);

    $existingVisitor = VisitorHandler::getVisitorByFbId(safe_input($jsonArray["id"]));

    $visitorRes = null;

    if ($existingVisitor != null){
        $existingVisitor->setFirstName(safe_input($jsonArray["first_name"]))->setLastName(safe_input($jsonArray["last_name"]))->setEmail(safe_input($jsonArray["email"]))->setImagePath(safe_input($jsonArray["picture"]['data']['url']));
        $visitorRes = VisitorHandler::updateVisitor($existingVisitor);
    } else {
        $visitor2Insert->setFirstName(safe_input($jsonArray["first_name"]))->setLastName(safe_input($jsonArray["last_name"]))->setEmail(safe_input($jsonArray["email"]))->setImagePath(safe_input($jsonArray["picture"]['data']['url']))->setUserStatus(VisitorStatus::ACTIVE)->setFBID(safe_input($jsonArray["id"]));
        $visitorRes = VisitorHandler::createVisitor($visitor2Insert);
    }

    echo $visitorRes;
} catch (SystemException $ex) {
    logError($ex);
    echo null;
}