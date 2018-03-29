<?php try { ?>
    <?php
    $id = $_GET['id'];
    $modalTitle = $_GET['modalTitle'];
    ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel_group_<?php echo $id ?>"><?php echo $modalTitle ?></h4>
    </div>
    <?php $action = getAdminActionRequestUri() . "access" . DS . "updateGroup"; ?>
    <form name="updateAccessForm" role="form" action="<?php echo $action; ?>" data-toggle="validator" method="post">
        <input type="hidden" name="<?php echo AccessRightsHandler::GROUP_ID ?>" value="<?php echo $id ?>"/>
        <?php require_safe(ADMIN_NAV_PATH . 'modalMessageSection' . PHP_POSTFIX) ?>
        <div class="modal-body text-center">
            <?php
            $userAccessRights = AccessRightsHandler::getAccessRightByGroupId($id);
            $allAccessRights = AccessRightsHandler::fetchAllAccessRights();
            ?>
            <div class="row">
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
                                           id="right_input_<?php echo $right->getID(); ?>"
                                           data-toggle="toggle"
                                           data-custom-on-val="<?php echo $right->getID(); ?>"
                                           data-custom-off-val="">
                                </label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input type="submit" name="submit" value="Save" placeholder="Save" class="btn btn-primary"/>
        </div>
    </form>
    <?php
} catch (SystemException $e) {
    logError($e);
}
?>