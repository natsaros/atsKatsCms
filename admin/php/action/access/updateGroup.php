<?php
/**
 * Updates group access
 */

$accessRights = safe_input($_POST[AccessRightsHandler::ACCESS_ID]);
$groupID = safe_input($_POST[AccessRightsHandler::GROUP_ID]);
FormHandler::validateMandatoryField($accessRights, 'Group should have access to at least one section');

try {
    if (hasErrors()) {
        Redirect(getAdminModalRequestUri() . "updateGroupAccess", addParamsToUrl(array('id'), array($groupID)));
    }

    $res = AccessRightsHandler::updateGroupAccessRights($groupID, $accessRights);
    if ($res !== null || $res) {
        addSuccessMessage("Access rights successfully updated");
    } else {
        addErrorMessage("Access rights failed to be updated");
    }
} catch (SystemException $e) {
    logError($e);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
    try {
        Redirect(getAdminModalRequestUri() . "updateGroupAccess", addParamsToUrl(array('id'), array($groupID)));
    } catch (SystemException $e) {
        logError($e);
    }
}