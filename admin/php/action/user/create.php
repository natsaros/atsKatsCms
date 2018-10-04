<?php

$updateFromMyProfile = filter_var(safe_input($_POST['updateFromMyProfile']), FILTER_VALIDATE_BOOLEAN);

$userName = safe_input($_POST[UserHandler::USERNAME]);
$email = safe_input($_POST[UserHandler::EMAIL]);
$phone = safe_input($_POST[UserHandler::PHONE]);


if (isEmpty($userName) || isEmpty($email)) {
    addErrorMessage("Please fill in required info");
}

if (!isValidMail($email)) {
    addErrorMessage("Please fill in a valid email address");
}

$userEmailExists = UserHandler::userEmailExists($email, null);

if ($userEmailExists == 1) {
    addErrorMessage("There is already a user with this email");
}

if (isNotEmpty(trim($phone))
    && !is_numeric($phone)) {
    addErrorMessage('Please fill in a valid phone number');
}

$image2Upload = FormHandler::validateUploadedImage(UserHandler::PICTURE);

$first_name = safe_input($_POST[UserHandler::FIRST_NAME]);
$last_name = safe_input($_POST[UserHandler::LAST_NAME]);
$gender = safe_input($_POST[UserHandler::GENDER]);
$link = safe_input($_POST[UserHandler::LINK]);

$groupIds = safe_input($_POST[GroupHandler::GROUP_ID]);

FormHandler::validateMandatoryField($groupIds, 'Please choose a group for the user');

$updateUserUrl = getAdminRequestUri() . DS . PageSections::USERS . DS . "updateUser";
if (hasErrors()) {
    FormHandler::setSessionForm('updateUserForm', $_POST[FormHandler::PAGE_ID]);
    Redirect($updateUserUrl);
}

$picturePath = safe_input($_POST[UserHandler::PICTURE_PATH]);
if (isEmpty($picturePath)) {
    $picturePath = FormHandler::getFormPictureDraftName(UserHandler::PICTURE);
}

try {
    $imgContent = isNotEmpty($image2Upload) ? ImageUtil::readImageContentFromFile($image2Upload) : false;

    $user2Create = User::createFullUser(null,
        $userName,
        null,
        $first_name,
        $last_name,
        $email,
        null,
        null,
        true,
        $gender,
        $link,
        $phone,
        null,
        null,
        1);

    if ($imgContent) {
        //only saving in filesystem for performance reasons
        $user2Create->setPicturePath($picturePath);

        //save image content also in blob on db for back up reasons if needed
//        $user2Create->setPicturePath($picturePath)->setPicture($imgContent);
    }

    $createUserRes = UserHandler::createUser($user2Create);

    if ($createUserRes && isNotEmpty($groupIds)) {
        UserHandler::updateUserGroups($createUserRes, $groupIds);
    }
    if ($createUserRes !== null || $createUserRes) {
        addSuccessMessage("User " . $user2Create->getUserName() . " successfully created");
        if (isNotEmpty($image2Upload)) {
            $fileName = basename($image2Upload[ImageUtil::NAME]);
            ImageUtil::saveImageToFileSystem(USERS_PICTURES_ROOT, $user2Create->getUserName(), $fileName, $imgContent);
        }
    } else {
        addErrorMessage("User " . $user2Create->getUserName() . " failed to be created");
    }

} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
    Redirect($updateUserUrl);
}

if (hasErrors()) {
    Redirect($updateUserUrl);
} else {
    FormHandler::unsetFormSessionToken();
    Redirect(getAdminRequestUri() . PageSections::USERS . DS . "users");
}