<?php require("pageHeader.php"); ?>

<?php require("messageSection.php"); ?>

<?php

$settingID = $_GET["id"];
$isCreate = isEmpty($settingID);

if($isCreate) {
    $curSetting = Setting::create();
} else {
    $curSetting = SettingsHandler::getSettingByID($settingID);
}
?>

<div class="row">
    <div class="col-lg-12">
        <?php
        $settingsURL = getAdminActionRequestUri() . "settings";
        $action = $isCreate ? $settingsURL . DS . "create" : $settingsURL . DS . "update";
        ?>
        <form name="updateSettingForm" role="form" action="<?php echo $action ?>" data-toggle="validator" method="post">
            <?php if(!$isCreate) { ?>
                <input type="hidden" name="<?php echo SettingsHandler::ID ?>" value="<?php echo $settingID; ?>"/>
                <input type="hidden" name="<?php echo SettingsHandler::SKEY ?>"
                       value="<?php echo $curSetting->getKey(); ?>"/>

                <?php if($curSetting->getKey() === Setting::BLOG_ENABLED) { ?>
                    <div class="form-group">
                        <label class="control-label"
                               for="setting_input_<?php echo $curSetting->getID(); ?>"><?php echo $curSetting->getKey(); ?></label>
                        <div class="checkbox">
                            <label>
                                <?php $isChecked = $curSetting->getValue() === 'on' ? 'checked' : '' ?>
                                <input name="<?php echo SettingsHandler::SVALUE; ?>[]"
                                       type="checkbox" <?php echo $isChecked ?>
                                       value="<?php echo $curSetting->getValue(); ?>"
                                       id="setting_input_<?php echo $curSetting->getID(); ?>"
                                       data-toggle="toggle"
                                       data-custom-on-val="on"
                                       data-custom-off-val="off">
                            </label>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="form-group">
                    <label class="control-label" for="key_input">Key</label>
                    <input class="form-control" placeholder="Key"
                           name="<?php echo SettingsHandler::SKEY ?>" id="key_input" required>
                </div>

                <div class="form-group">
                    <label class="control-label" for="value_input">Value</label>
                    <input class="form-control" placeholder="Value"
                           name="<?php echo SettingsHandler::SVALUE ?>" id="value_input" required>
                </div>
            <?php } ?>

            <div class="text-right form-group">
                <a type="button" href="<?php echo getAdminRequestUri() . 'settings' ?>"
                   class="btn btn-default">Back</a>
                <input type="submit" name="submit" class="btn btn-primary" value="Save" placeholder="Save"/>
            </div>
        </form>
    </div>
</div>