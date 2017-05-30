<?php
$userName = safe_input($_POST[UserHandler::USERNAME]);
$email = safe_input($_POST[UserHandler::EMAIL]);

if (isEmpty($userName) || isEmpty($email)) {
    //    TODO : add php side form validation message
    //    addInfoMessage("Please fill in required info");
}
$ID = safe_input($_POST[UserHandler::ID]);
$first_name = safe_input($_POST[UserHandler::FIRST_NAME]);
$last_name = safe_input($_POST[UserHandler::LAST_NAME]);
$user_status = safe_input($_POST[UserHandler::USER_STATUS]);
$is_admin = safe_input($_POST[UserHandler::IS_ADMIN]);
$gender = safe_input($_POST[UserHandler::GENDER]);
$link = safe_input($_POST[UserHandler::LINK]);
$phone = safe_input($_POST[UserHandler::PHONE]);
$picture = safe_input($_POST[UserHandler::PICTURE]);

try {
    $user2Update = UserHandler::getUserById($ID);
    if (isNotEmpty($user2Update)) {
        $user2Update->setUserName($userName)->setFirstName($first_name)->setLastName($last_name)
            ->setEmail($email)->setUserStatus($user_status)->setIsAdmin($is_admin)
            ->setGender($gender)->setLink($link)->setPhone($phone)->setPicture($picture);
        $updateUserRes = UserHandler::updateUser($user2Update);

        if ($updateUserRes !== null || $updateUserRes) {
            addSuccessMessage("User " . $user2Update->getUserName() . " successfully updated");
        } else {
            addErrorMessage("User " . $user2Update->getUserName() . " failed to be updated");
        }
    } else {
        addErrorMessage(ErrorMessages::GENERIC_ERROR);
    }
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

if (hasErrors()) {
    Redirect(getAdminRequestUri() . "updateUser");
} else {
    Redirect(getAdminRequestUri() . "users");
}