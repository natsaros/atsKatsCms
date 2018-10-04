<?php
$ID = safe_input($_POST[SettingsHandler::ID]);
$key = safe_input($_POST[SettingsHandler::SKEY]);
if ($key === Setting::MAINTENANCE) {
    $value = $_POST[SettingsHandler::SVALUE][0];
    if (isEmpty($value)) {
        $value = 'off';
    }
} else if ($key === Setting::BLOG_ENABLED) {
    $value = $_POST[SettingsHandler::SVALUE][0];
    if (isEmpty($value)) {
        $value = 'off';
    }
} else if ($key === Setting::BLOG_STYLE) {
    $value = $_POST[SettingsHandler::SVALUE][0];
    if (isEmpty($value)) {
        $value = 'list';
    }
} else {
    $value = $_POST[SettingsHandler::SVALUE];
}

if (isEmpty($key) || isEmpty($value)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . DS . PageSections::SETTINGS . DS . "updateSetting");
}
try {
    $setting = SettingsHandler::getSettingByID($ID);
    $setting->setKey($key)->setValue($value);

    $result = SettingsHandler::update($setting);
    if ($result !== null || $result) {
        addSuccessMessage("Setting '" . $setting->getKey() . "' successfully updated");
    } else {
        addErrorMessage("Setting '" . $setting->getKey() . "' failed to be updated");
    }
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

if (hasErrors()) {
    Redirect(getAdminRequestUri() . PageSections::SETTINGS . DS . "updateSetting");
} else {
    Redirect(getAdminRequestUri() . PageSections::SETTINGS . DS . "settings");
}