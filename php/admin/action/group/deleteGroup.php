<?php
/**
 * Deletes a group
 */

$id = $_GET['id'];

if(isEmpty($id)) {
    addInfoMessage("Choose group to delete");
    Redirect(getAdminRequestUri() . 'users' . addParamsToUrl(array('activeTab'), array('groups')));
}

try {
    $group = GroupHandler::getGroupById($id);
    if(isNotEmpty($group)) {
        if($group->getStatus() == GroupStatus::ACTIVE) {
            addInfoMessage("Group '" . $group->getName() . "' is published and cannot be deleted");
        } else {
            $res = GroupHandler::deleteGroup($id);
            if($res !== null || $res) {
                addSuccessMessage("Group successfully deleted");
            } else {
                addErrorMessage("Group failed to be deleted");
            }
        }
    } else {
        addInfoMessage(ErrorMessages::WENT_WRONG);
    }
} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

Redirect(getAdminRequestUri() . 'users' . addParamsToUrl(array('activeTab'), array('groups')));
