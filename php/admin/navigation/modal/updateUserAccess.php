<?php $id = $_GET['id'] ?>
<?php $modalTitle = $_GET['modalTitle'];
$errorMessages = consumeErrorMessages();
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel_<?php echo $id ?>"><?php echo $modalTitle ?></h4>
</div>
<?php $action = getAdminActionRequestUri() . "access" . DS . "updateUser"; ?>
<form name="updateAccessForm" role="form" action="<?php echo $action; ?>" data-toggle="validator" method="post">
    <input type="hidden" name="<?php echo AccessRightsHandler::USER_ID ?>" value="<?php echo $id ?>"/>
    <?php if (isNotEmpty($errorMessages)) {
        /* @var $msg string */
        foreach ($errorMessages as $key => $msg) {
            ?>
            <div class="alert alert-danger alert-dismissable fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo $msg ?>
            </div>
            <?php
        }
    } ?>
    <div class="modal-body text-center">
        <?php
        $userAccessRights = AccessRightsHandler::getAccessRightByUserId($id);
        $allAccessRights = AccessRightsHandler::fetchAllAccessRights();
        ?>

        <div class="col-lg-12">
            <?php
            /* @var $right AccessRight */
            foreach ($allAccessRights as $key => $right) {
                ?>
                <div class="form-group">
                    <label class="control-label"
                           for="right_input_<?php echo $right->getID(); ?>"><?php echo $right->getDescription(); ?></label>
                    <div class="checkbox">
                        <label>
                            <?php $isChecked = isNotEmpty($userAccessRights) ? in_array($right, $userAccessRights) ? 'checked' : '' : '' ?>
                            <input name="<?php echo AccessRightsHandler::ACCESS_ID; ?>[]"
                                   type="checkbox" <?php echo $isChecked ?>
                                   value="<?php echo $right->getID(); ?>"
                                   data-toggle="toggle" data-on="true" data-off="false">
                        </label>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" name="submit" value="Save" placeholder="Save" class="btn btn-primary"/>
    </div>
</form>