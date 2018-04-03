<?php
/**
 * creates a group
 */

$name = safe_input($_POST[GroupHandler::GROUP_NAME]);

if (isEmpty($name)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . "updateGroup");
}

try {
    $group2Create = Group::createGroup(null, $name, GroupStatus::ACTIVE);
    $res = GroupHandler::create($group2Create);

    if ($res !== null || $res) {
        addSuccessMessage("Group " . $group2Create->getName() . " successfully created");
    } else {
        addErrorMessage("Group " . $group2Create->getName() . " failed to be created");
    }

} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

if (hasErrors()) {
    Redirect(getAdminRequestUri() . DS . PageSections::USERS . DS . "updateGroup");
} else {
    Redirect(getAdminRequestUri() . DS . PageSections::USERS . DS . 'users' . addParamsToUrl(array('activeTab'), array('groups')));
}