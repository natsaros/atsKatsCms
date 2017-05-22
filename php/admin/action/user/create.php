<?php
$password = safe_input($_POST[UserHandler::PASSWORD]);
$userName = safe_input($_POST[UserHandler::USERNAME]);
$email = safe_input($_POST[UserHandler::EMAIL]);

if(isEmpty($password) || isEmpty($userName) || isEmpty($email)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . "updateUser" . addParamsToUrl(array('id'), array($ID)));
}

$first_name = safe_input($_POST[UserHandler::FIRST_NAME]);
$last_name = safe_input($_POST[UserHandler::LAST_NAME]);
$is_admin = safe_input($_POST[UserHandler::IS_ADMIN]);
$gender = safe_input($_POST[UserHandler::GENDER]);
$link = safe_input($_POST[UserHandler::LINK]);
$phone = safe_input($_POST[UserHandler::PHONE]);
$picture = safe_input($_POST[UserHandler::PICTURE]);
try {
    $user2Create = User::createFullUser(null, $userName, password_hash($password, PASSWORD_DEFAULT), $first_name, $last_name, $email, date('Y-m-d'), null, true, $is_admin, $gender, $link, $phone, $picture);
    $createUserRes = UserHandler::createUser($user2Create);

    if($createUserRes !== null || $createUserRes) {
        addSuccessMessage("User " . $user2Create->getUserName() . " successfully created");
    } else {
        addErrorMessage("User " . $user2Create->getUserName() . " failed to be created");
    }

} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}
if(hasErrors()) {
    Redirect(getAdminRequestUri() . "updateUser" . addParamsToUrl(array('id'), array($ID)));
} else {
    Redirect(getAdminRequestUri() . "users");
}