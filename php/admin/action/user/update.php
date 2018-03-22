<?php
$updateLoggedInUser = safe_input($_POST['updateLoggedInUser']);

$userName = safe_input($_POST[UserHandler::USERNAME]);
$email = safe_input($_POST[UserHandler::EMAIL]);

if(isEmpty($userName) || isEmpty($email)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . "updateUser" . addParamsToUrl(array('id'), array($ID)));
}

$ID = safe_input($_POST[UserHandler::ID]);
$first_name = safe_input($_POST[UserHandler::FIRST_NAME]);
$last_name = safe_input($_POST[UserHandler::LAST_NAME]);
$password = safe_input($_POST[UserHandler::PASSWORD]);
$password = safe_input($_POST[UserHandler::PASSWORD_CONFIRMATION]);
$user_status = safe_input($_POST[UserHandler::USER_STATUS]);
$gender = safe_input($_POST[UserHandler::GENDER]);
$link = safe_input($_POST[UserHandler::LINK]);
$phone = safe_input($_POST[UserHandler::PHONE]);

$groupIds = '';
if (isEmpty($updateLoggedInUser) || !boolval($updateLoggedInUser)){
    $groupIds = safe_input($_POST[GroupHandler::GROUP_ID]);
}

$picturePath = safe_input($_POST[UserHandler::PICTURE_PATH]);

$imageValid = true;
$image2Upload = $_FILES[UserHandler::PICTURE];
$emptyFile = $image2Upload['error'] === UPLOAD_ERR_NO_FILE;
if(!$emptyFile) {
    $imageValid = ImageUtil::validateImageAllowed($image2Upload);
}

if(!$imageValid) {
    addInfoMessage("Please select a valid image file");
    Redirect(getAdminRequestUri() . "updateUser" . addParamsToUrl(array('id'), array($ID)));
}

try {
    $user2Update = UserHandler::getUserById($ID);
    $imgContent = !$emptyFile ? ImageUtil::readImageContentFromFile($image2Upload) : false;

    if(isNotEmpty($user2Update)) {
        $user2Update->
        setUserName($userName)->
        setFirstName($first_name)->
        setLastName($last_name)->
        setEmail($email)->
        setUserStatus($user_status)->
        setGender($gender)->
        setLink($link)->
        setPhone($phone)->
        setPassword(password_hash($password, PASSWORD_DEFAULT))->
        setForceChangePassword(0);

        if($imgContent) {
            //only saving in filesystem for performance reasons
            $user2Update->setPicturePath($picturePath);

            //save image content also in blob on db for back up reasons if needed
//            $user2Update->setPicturePath($picturePath)->setPicture($imgContent);
        }

        $updateUserRes = UserHandler::updateUser($user2Update);
        if($updateUserRes && isNotEmpty($groupIds)) {
            UserHandler::updateUserGroups($user2Update->getID(), $groupIds);
        }
        if($updateUserRes !== null || $updateUserRes) {
            if (isEmpty($updateLoggedInUser) || !boolval($updateLoggedInUser)){
                addSuccessMessage("User " . $user2Update->getUserName() . " successfully updated");
            } else {
                addSuccessMessage("Your profile has been successfully updated");
            }
            if(!$emptyFile) {
                $fileName = basename($image2Upload[ImageUtil::NAME]);
                ImageUtil::saveImageToFileSystem(USERS_PICTURES_ROOT, $user2Update->getUserName(), $fileName, $imgContent);
            }
            if (isNotEmpty($updateLoggedInUser) && boolval($updateLoggedInUser)){
                $user2Update->setAccessRights(AccessRightsHandler::getAccessRightByUserId($user2Update->getID()));
                setUserToSession($user2Update);
            }
        } else {
            if (isEmpty($updateLoggedInUser) || !boolval($updateLoggedInUser)){
                addErrorMessage("User " . $user2Update->getUserName() . " failed to be updated");
            } else {
                addErrorMessage("Your profile failed to be updated");
            }
        }
    } else {
        addErrorMessage(ErrorMessages::GENERIC_ERROR);
    }
} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

if(hasErrors()) {
    if (isEmpty($updateLoggedInUser) || !boolval($updateLoggedInUser)){
        Redirect(getAdminRequestUri() . "updateUser");
    } else {
        Redirect(getAdminRequestUri() . "updateMyProfile");
    }
} else {
    if (isEmpty($updateLoggedInUser) || !boolval($updateLoggedInUser)){
        Redirect(getAdminRequestUri() . "users");
    } else {
        Redirect(getAdminRequestUriNoDelim());
    }
}