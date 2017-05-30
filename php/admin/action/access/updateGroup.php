<?php
/**
 * Updates group access
 */

$accessRights = safe_input($_POST[AccessRightsHandler::ACCESS_ID]);
$groupID = safe_input($_POST[AccessRightsHandler::GROUP_ID]);

try {
    $res = AccessRightsHandler::updateGroupAccessRights($groupID, $accessRights);
    if ($res !== null || $res) {
        addSuccessMessage("Access rights successfully updated");
    } else {
        addErrorMessage("Access rights failed to be updated");
    }
} catch (SystemException $e) {
    logError($e);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}