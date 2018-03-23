<?php
$key = safe_input($_POST[SettingsHandler::SKEY]);
$value = $_POST[SettingsHandler::SVALUE];

if(isEmpty($key) || isEmpty($value)) {
    addInfoMessage("Please fill in required info");
    Redirect(getAdminRequestUri() . "updateSetting");
}
try {
    $setting = Setting::createFull(null, $key, $value);

    $result = SettingsHandler::create($setting);
    if($result !== null || $result) {
        addSuccessMessage("Setting '" . $setting->getKey() . "' successfully created");
    } else {
        addErrorMessage("Setting '" . $setting->getKey() . "' failed to be created");
    }
} catch(SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}

if(hasErrors()) {
    Redirect(getAdminRequestUri() . "updateSetting");
} else {
    Redirect(getAdminRequestUri() . "settings");
}