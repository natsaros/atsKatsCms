<?php
/**
 * Updates user access
 */
$accessRights = safe_input($_POST[AccessRightsHandler::ACCESS_ID]);
$userID = safe_input($_POST[AccessRightsHandler::USER_ID]);
FormHandler::validateMandatoryField($accessRights, 'User should have access to at least one section');

try {
    if (hasErrors()) {
        Redirect(getAdminModalRequestUri() . "updateUserAccess", addParamsToUrl(array('id'), array($userID)));
    }

    $user = UserHandler::getUserById($userID);

    $res = AccessRightsHandler::updateUserAccessRights($user, $accessRights);
    if ($res !== null || $res) {
        addSuccessMessage("Access rights successfully updated");
    } else {
        addErrorMessage("Access rights failed to be updated");
    }
} catch (SystemException $e) {
    logError($e);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
    try {
        Redirect(getAdminModalRequestUri() . "updateUserAccess", addParamsToUrl(array('id'), array($userID)));
    } catch (SystemException $e) {
        logError($e);
    }
}