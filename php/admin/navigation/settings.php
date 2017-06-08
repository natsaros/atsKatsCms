<?php require("pageHeader.php"); ?>

<?php require("messageSection.php"); ?>

<?php
$settings = SettingsHandler::fetchAllSettings();
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover ak-dataTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Key</th>
                    <th>Value</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                /* @var $setting Setting */
                foreach($settings as $key => $setting) {
                    $oddEvenClass = $key % 2 == 0 ? 'odd' : 'even';
                    $settingID = $setting->getID();
                    ?>
                    <tr class="<?php echo $oddEvenClass ?>">
                        <td><?php echo $settingID; ?></td>
                        <td><?php echo $setting->getKey(); ?></td>
                        <td><?php echo $setting->getValue(); ?></td>
                        <td>

                            <a type="button"
                               href="<?php echo getAdminActionRequestUri() . "settings" . DS . "delete" . addParamsToUrl(array('id'), array($settingID)); ?>"
                               class="btn btn-default btn-sm" title="Delete Setting">
                                <span class="glyphicon glyphicon-erase" aria-hidden="true"></span>
                            </a>

                            <a type="button"
                               href="<?php echo getAdminRequestUri() . "updateSetting" . addParamsToUrl(array('id'), array($settingID)); ?>"
                               class="btn btn-default btn-sm" title="Edit Setting">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 text-center">
        <a href="<?php echo getAdminRequestUri() . "updateSetting"; ?>" type="button"
           class="btn btn-outline btn-primary">
            Add <span class="fa fa-cog fa-fw" aria-hidden="true"></span>
        </a>
    </div>
</div>