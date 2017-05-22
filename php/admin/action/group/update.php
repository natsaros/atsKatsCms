<?php
/**
 * updated a group
 */

$ID = safe_input($_POST[GroupHandler::ID]);
$name = safe_input($_POST[GroupHandler::GROUP_NAME]);
$status = safe_input($_POST[GroupHandler::STATUS]);

$meta_keys = safe_input($_POST[GroupHandler::META_KEY]);
$meta_values = safe_input($_POST[GroupHandler::META_KEY]);

if(isEmpty($name)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . "updateGroup" . addParamsToUrl(array('id'), array($ID)));
}

try {
    $group = GroupHandler::getGroupById($ID);
    if(isNotEmpty($group)) {
        $group->setName($name)->setStatus($status);
        if(isNotEmpty($meta_keys) && isNotEmpty($meta_values)) {
            foreach($meta_keys as $key) {
//                TODO : handle here meta keys and values
            }
        }

        $res = GroupHandler::update($group);

        if($res !== null || $res) {
            addSuccessMessage("Group " . $group->getName() . " successfully created");
        } else {
            addErrorMessage("Group " . $group->getName() . " failed to be created");
        }
    } else {
        addErrorMessage(ErrorMessages::GENERIC_ERROR);
    }
} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}
if(hasErrors()) {
    Redirect(getAdminRequestUri() . "updateGroup" . addParamsToUrl(array('id'), array($ID)));
} else {
    Redirect(getAdminRequestUri() . 'users' . addParamsToUrl(array('activeTab'), array('groups')));
}