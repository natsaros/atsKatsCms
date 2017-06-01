<?php
/**
 * Updates user access
 */

$accessRights = safe_input($_POST[AccessRightsHandler::ACCESS_ID]);
$userID = safe_input($_POST[AccessRightsHandler::USER_ID]);

try {
    $res = AccessRightsHandler::updateUserAccessRights($userID, $accessRights);
    if($res !== null || $res) {
        addSuccessMessage("Access rights successfully updated");
    } else {
        addErrorMessage("Access rights failed to be updated");
    }
} catch(SystemException $e) {
    logError($e);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}