<?php
$password = safe_input($_POST[UserHandler::PASSWORD]);
$userName = safe_input($_POST[UserHandler::USERNAME]);
$email = safe_input($_POST[UserHandler::EMAIL]);

if (isEmpty($password) || isEmpty($userName) || isEmpty($email)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . "updateUser");
}

$first_name = safe_input($_POST[UserHandler::FIRST_NAME]);
$last_name = safe_input($_POST[UserHandler::LAST_NAME]);
$gender = safe_input($_POST[UserHandler::GENDER]);
$link = safe_input($_POST[UserHandler::LINK]);
$phone = safe_input($_POST[UserHandler::PHONE]);

$groupIds = safe_input($_POST[GroupHandler::GROUP_ID]);

$picturePath = safe_input($_POST[UserHandler::PICTURE_PATH]);

$imageValid = true;
$image2Upload = $_FILES[UserHandler::PICTURE];
$emptyFile = $image2Upload['error'] === UPLOAD_ERR_NO_FILE;
if (!$emptyFile) {
    $imageValid = ImageUtil::validateImageAllowed($image2Upload);
}

if (!$imageValid) {
    addInfoMessage("Please select a valid image file");
    Redirect(getAdminRequestUri() . "updateUser");
}


try {
    $imgContent = !$emptyFile ? ImageUtil::readImageContentFromFile($image2Upload) : false;

    $user2Create = User::createFullUser(null, $userName, password_hash($password, PASSWORD_DEFAULT), $first_name, $last_name, $email, date('Y-m-d'), null, true, $gender, $link, $phone, null, null);
    if ($imgContent) {
        //save image content also in blob on db for back up reasons if needed
        $user2Create->setPicturePath($picturePath)->setPicture($imgContent);
    }
    $createUserRes = UserHandler::createUser($user2Create);

    if ($createUserRes && isNotEmpty($groupIds)) {
        UserHandler::updateUserGroups($createUserRes, $groupIds);
    }
    if ($createUserRes !== null || $createUserRes) {
        addSuccessMessage("User " . $user2Create->getUserName() . " successfully created");
        if(!$emptyFile){
            ImageUtil::saveImageToFileSystem($user2Create->getUserName(), $image2Upload);
        }
    } else {
        addErrorMessage("User " . $user2Create->getUserName() . " failed to be created");
    }

} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}
if (hasErrors()) {
    Redirect(getAdminRequestUri() . "updateUser" . addParamsToUrl(array('id'), array($ID)));
} else {
    Redirect(getAdminRequestUri() . "users");
}