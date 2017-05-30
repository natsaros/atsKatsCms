<?php
/**
 * updates group status
 */

$id = $_GET['id'];
$status = $_GET['status'];
try {
    $updateGroupStatusRes = GroupHandler::updateGroupStatus($id, $status);

    if ($updateGroupStatusRes !== null || $updateGroupStatusRes) {
        addSuccessMessage("Group status successfully changed");
    } else {
        addErrorMessage("Group status failed to be changed");
    }
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}
Redirect(getAdminRequestUri() . 'users' . addParamsToUrl(array('activeTab'), array('groups')));