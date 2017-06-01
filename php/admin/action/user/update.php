<?php
$userName = safe_input($_POST[UserHandler::USERNAME]);
$email = safe_input($_POST[UserHandler::EMAIL]);

if (isEmpty($userName) || isEmpty($email)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . "updateUser" . addParamsToUrl(array('id'), array($ID)));
}
$ID = safe_input($_POST[UserHandler::ID]);
$first_name = safe_input($_POST[UserHandler::FIRST_NAME]);
$last_name = safe_input($_POST[UserHandler::LAST_NAME]);
$user_status = safe_input($_POST[UserHandler::USER_STATUS]);
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
    Redirect(getAdminRequestUri() . "updateUser" . addParamsToUrl(array('id'), array($ID)));
}

try {
    $user2Update = UserHandler::getUserById($ID);
    $imgContent = !$emptyFile ? ImageUtil::readImageContentFromFile($image2Upload) : false;

    if (isNotEmpty($user2Update)) {
        $user2Update->setUserName($userName)->setFirstName($first_name)->setLastName($last_name)
            ->setEmail($email)->setUserStatus($user_status)->setGender($gender)
            ->setLink($link)->setPhone($phone);


        if ($imgContent) {
            //save image content also in blob on db for back up reasons if needed
            $user2Update->setPicturePath($picturePath)->setPicture($imgContent);
        }

        $updateUserRes = UserHandler::updateUser($user2Update);
        if ($updateUserRes && isNotEmpty($groupIds)) {
            UserHandler::updateUserGroups($user2Update->getID(), $groupIds);
        }
        if ($updateUserRes !== null || $updateUserRes) {
            addSuccessMessage("User " . $user2Update->getUserName() . " successfully updated");
            if(!$emptyFile){
                ImageUtil::saveImageToFileSystem($user2Update->getUserName(), $image2Upload);
            }
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