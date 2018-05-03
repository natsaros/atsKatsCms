<?php

$updateFromMyProfile = filter_var(safe_input($_POST['updateFromMyProfile']), FILTER_VALIDATE_BOOLEAN);

$ID = safe_input($_POST[UserHandler::ID]);
$userName = safe_input($_POST[UserHandler::USERNAME]);
$email = safe_input($_POST[UserHandler::EMAIL]);
$phone = safe_input($_POST[UserHandler::PHONE]);
$password = safe_input($_POST[UserHandler::PASSWORD]);
$passwordConfirmation = safe_input($_POST[UserHandler::PASSWORD_CONFIRMATION]);

if (isEmpty($userName) || isEmpty($email)) {
    addErrorMessage("Please fill in required info");
}

if ($updateFromMyProfile
    && (isEmpty($password) || isEmpty($passwordConfirmation) || $password !== $passwordConfirmation)) {
    addErrorMessage("Please fill in a valid password");
}

if (!isValidMail($email)) {
    addErrorMessage("Please fill in a valid email address");
}

$userEmailExists = UserHandler::userEmailExists($email, $ID);
if ($userEmailExists == 1) {
    addErrorMessage("There is already a user with this email");
}

if (isNotEmpty(trim($phone)) && !is_numeric($phone)) {
    addErrorMessage('Please fill in a valid phone number');
}

$image2Upload = FormHandler::validateUploadedImage(UserHandler::PICTURE);

$updateUserUrl = getAdminRequestUri() . DS . PageSections::USERS . DS . "updateUser";
if (hasErrors()) {
    if (!empty($_POST)) {
        if (!$updateFromMyProfile) {
            FormHandler::setSessionForm('updateUserForm');
            Redirect($updateUserUrl . addParamsToUrl(array('id'), array($ID)));
        } else {
            foreach ($_POST as $key => $value) {
                $_SESSION['updateMyProfileForm'][$key] = $value;
            }
            $_SESSION['updateMyProfileForm'][$key] = $value;
            Redirect(getAdminRequestUri() . DS . PageSections::USERS . DS . "updateMyProfile");
        }
    }
}

$first_name = safe_input($_POST[UserHandler::FIRST_NAME]);
$last_name = safe_input($_POST[UserHandler::LAST_NAME]);
$user_status = safe_input($_POST[UserHandler::USER_STATUS]);
$gender = safe_input($_POST[UserHandler::GENDER]);
$link = safe_input($_POST[UserHandler::LINK]);

$groupIds = '';
if (!$updateFromMyProfile) {
    $groupIds = safe_input($_POST[GroupHandler::GROUP_ID]);
}

$picturePath = safe_input($_POST[UserHandler::PICTURE_PATH]);
if (isEmpty($picturePath)) {
    $picturePath = FormHandler::getFormPictureDraftName(UserHandler::PICTURE);
}

try {
    $user2Update = UserHandler::getUserById($ID);
    $imgContent = isNotEmpty($image2Upload) ? ImageUtil::readImageContentFromFile($image2Upload) : false;

    if (isNotEmpty($user2Update)) {
        $user2Update->
        setUserName($userName)->
        setFirstName($first_name)->
        setLastName($last_name)->
        setEmail($email)->
        setUserStatus($user_status)->
        setGender($gender)->
        setLink($link)->
        setPhone($phone)->
        setForceChangePassword(0);

        if ($updateFromMyProfile) {
            $user2Update->setPassword(password_hash($password, PASSWORD_DEFAULT));
        }

        if ($imgContent) {
            //only saving in filesystem for performance reasons
            $user2Update->setPicturePath($picturePath);

            //save image content also in blob on db for back up reasons if needed
//            $user2Update->setPicturePath($picturePath)->setPicture($imgContent);
        }

        $updateUserRes = UserHandler::updateUser($user2Update);

        if ($updateUserRes && isNotEmpty($groupIds)) {
            UserHandler::updateUserGroups($user2Update->getID(), $groupIds);
        }
        if ($updateUserRes !== null || $updateUserRes) {
            if (!$updateFromMyProfile) {
                addSuccessMessage("User " . $user2Update->getUserName() . " successfully updated");
            } else {
                addSuccessMessage("Your profile has been successfully updated");
            }
            if (isNotEmpty($image2Upload)) {
                $fileName = basename($image2Upload[ImageUtil::NAME]);
                ImageUtil::saveImageToFileSystem(USERS_PICTURES_ROOT, $user2Update->getUserName(), $fileName, $imgContent);
            }
            if ($updateFromMyProfile) {
                $user2Update->setAccessRights(AccessRightsHandler::getAccessRightByUserId($user2Update->getID()));
                setUserToSession($user2Update);
            }
        } else {
            if (!$updateFromMyProfile) {
                addErrorMessage("User " . $user2Update->getUserName() . " failed to be updated");
            } else {
                addErrorMessage("Your profile failed to be updated");
            }
        }
    } else {
        addErrorMessage(ErrorMessages::GENERIC_ERROR);
    }
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
    Redirect($updateUserUrl . addParamsToUrl(array('id'), array($ID)));
}

if (hasErrors()) {
    if ($updateFromMyProfile) {
        Redirect($updateUserUrl . addParamsToUrl(array('id'), array($ID)));
    } else {
        Redirect(getAdminRequestUri() . PageSections::USERS . DS . "updateMyProfile");
    }
} else {
    FormHandler::unsetFormSessionToken();
    if (!$updateFromMyProfile) {
        Redirect(getAdminRequestUri() . PageSections::USERS . DS . "users");
    } else {
        Redirect(getAdminRequestUriNoDelim());
    }
}