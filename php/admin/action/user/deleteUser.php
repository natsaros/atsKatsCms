<?php
$id = $_GET['id'];

FormHandler::validateMandatoryField($id, 'Choose user to delete');
if (hasErrors()) {
    Redirect(getAdminRequestUri() . DS . PageSections::USERS . DS . 'users');
}
try {

    $user = UserHandler::getUserById($id);
    if (isNotEmpty($user)) {
        if ($user->isUserActive()) {
            addInfoMessage("User {$group->getName()} is published and cannot be deleted");
        } else {
            $deleteUserRes = UserHandler::deleteUser($id);

            if ($deleteUserRes !== null || $deleteUserRes) {
                addSuccessMessage("User successfully deleted");
            } else {
                addErrorMessage("User failed to be deleted");
            }
        }
    } else {
        addInfoMessage("User with id {$id} could not be retrieved");
    }
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}
Redirect(getAdminRequestUri() . PageSections::USERS . DS . 'users');