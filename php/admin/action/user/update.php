<?php
$userName = safe_input($_POST[UserFetcher::USERNAME]);
$email = safe_input($_POST[UserFetcher::EMAIL]);

if(isEmpty($userName) || isEmpty($email)) {
    //    TODO : add php side form validation message
    //    addInfoMessage("Please fill in required info");
}
$ID = safe_input($_POST[UserFetcher::ID]);
$first_name = safe_input($_POST[UserFetcher::FIRST_NAME]);
$last_name = safe_input($_POST[UserFetcher::LAST_NAME]);
$user_status = safe_input($_POST[UserFetcher::USER_STATUS]);
$is_admin = safe_input($_POST[UserFetcher::IS_ADMIN]);
$gender = safe_input($_POST[UserFetcher::GENDER]);
$link = safe_input($_POST[UserFetcher::LINK]);
$phone = safe_input($_POST[UserFetcher::PHONE]);
$picture = safe_input($_POST[UserFetcher::PICTURE]);

try {
    $user2Update = User::createFullUser($ID, $userName, null, $first_name, $last_name, $email, null, null, $user_status, $is_admin, $gender, $link, $phone, $picture);
    $updateUserRes = UserFetcher::updateUser($user2Update);

    if($updateUserRes == null || !$updateUserRes) {
        addErrorMessage("User " . $user2Update->getUserName() . " failed to be updated");
    } else {
        addSuccessMessage("User " . $user2Update->getUserName() . " successfully updated");
    }
} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}
Redirect(sprintf(getAdminRequestUri() . "updateUser?id=%s", $user2Update->getID()));