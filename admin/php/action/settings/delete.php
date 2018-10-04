<?php
$id = $_GET['id'];

if (isEmpty($id)) {
    addInfoMessage("Choose setting to delete");
    Redirect(getAdminRequestUri() . PageSections::SETTINGS . DS . "settings");
}

try {
    $setting = SettingsHandler::getSettingByID($id);
    if (isNotEmpty($setting)) {
        $result = SettingsHandler::delete($id);
        if ($result == null || !$result) {
            addErrorMessage("Setting failed to be deleted");
        } else {
            addSuccessMessage("Setting successfully deleted");
        }
    } else {
        addInfoMessage(ErrorMessages::WENT_WRONG);
    }
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

Redirect(getAdminRequestUri() . PageSections::SETTINGS . DS . "settings");