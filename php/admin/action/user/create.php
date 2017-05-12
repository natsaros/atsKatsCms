<?php
$password = safe_input($_POST[UserFetcher::PASSWORD]);
$userName = safe_input($_POST[UserFetcher::USERNAME]);
$email = safe_input($_POST[UserFetcher::EMAIL]);

if(isEmpty($password) || isEmpty($userName) || isEmpty($email)) {
    //    TODO : add php side form validation message
    //    addInfoMessage("Please fill in required info");
}

$first_name = safe_input($_POST[UserFetcher::FIRST_NAME]);
$last_name = safe_input($_POST[UserFetcher::LAST_NAME]);
$is_admin = safe_input($_POST[UserFetcher::IS_ADMIN]);
$gender = safe_input($_POST[UserFetcher::GENDER]);
$link = safe_input($_POST[UserFetcher::LINK]);
$phone = safe_input($_POST[UserFetcher::PHONE]);
$picture = safe_input($_POST[UserFetcher::PICTURE]);
try {
    $user2Create = User::createFullUser(null, $userName, password_hash($password, PASSWORD_DEFAULT), $first_name, $last_name, $email, date('Y-m-d'), null, true, $is_admin, $gender, $link, $phone, $picture);
    $createUserRes = UserFetcher::createUser($user2Create);

    if($createUserRes == null || !$createUserRes) {
        addErrorMessage("User " . $user2Create->getUserName() . " failed to be created");
    } else {
        addSuccessMessage("User " . $user2Create->getUserName() . " successfully created");
    }

} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}
Redirect(getAdminRequestUri() . "users");