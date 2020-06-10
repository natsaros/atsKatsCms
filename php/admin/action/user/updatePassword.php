<?php

$ID = safe_input($_POST[UserHandler::ID]);
$password = safe_input($_POST[UserHandler::PASSWORD]);
$passwordConfirmation = safe_input($_POST[UserHandler::PASSWORD_CONFIRMATION]);

if (isEmpty($password) || isEmpty($passwordConfirmation) || $password !== $passwordConfirmation) {
    addErrorMessage("Please fill in a valid password");
}

if (hasErrors()) {
    if (!empty($_POST)) {
        FormHandler::setSessionForm('updateMyProfileForm', $_POST[FormHandler::PAGE_ID]);
        Redirect(getAdminRequestUri() . "updateMyProfile");
    }
}

try {
    if (isNotEmpty($ID)) {
        $updateUserPasswordRes = UserHandler::changePassword($ID, $password);

        if ($updateUserPasswordRes !== null || $updateUserPasswordRes) {
            addSuccessMessage("Your password has been successfully updated");
        } else {
            addErrorMessage("Your password failed to be updated");
        }
    } else {
        addErrorMessage(ErrorMessages::GENERIC_ERROR);
    }
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
    Redirect(getAdminRequestUri() . "updateMyProfile");
}

if (hasErrors()) {
    Redirect(getAdminRequestUri() . "updateMyProfile");
} else {
    Redirect(getAdminRequestUriNoDelim());
}