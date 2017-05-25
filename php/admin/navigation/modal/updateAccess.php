<?php $id = $_GET['id'] ?>
<?php require("modalHeader.php"); ?>
<div class="modal-content">
    <?php

    $userAccessRights = AccessRightsHandler::getAccessRightByUserId($id);
    $allAccessRights = AccessRightsHandler::fetchAllAccessRights();
    ?>

    <div class="col-lg-12">
        <?php $action = getAdminActionRequestUri() . "access" . DS . "update"; ?>
        <form name="updateAccessForm" role="form" action="<?php echo $action; ?>" data-toggle="validator"
              method="post">
            <?php
            /* @var $right AccessRight */
            foreach($allAccessRights as $key => $right) {
                ?>
                <div class="form-group">
                    <label class="control-label"
                           for="right_input_<?php echo $right->getID(); ?>"><?php echo $right->getDescription(); ?></label>
                    <div class="checkbox">
                        <label>
                            <?php $isChecked = isNotEmpty($userAccessRights) ? in_array($right, $userAccessRights) ? 'checked' : '' : '' ?>
                            <input name="<?php echo AccessRightsHandler::ACCESS_ID; ?>[]"
                                   type="checkbox" <?php echo $isChecked ?>
                                   data-toggle="toggle" data-on="true" data-off="false">
                        </label>
                    </div>
                </div>
            <?php } ?>
        </form>
    </div>
</div>
<?php require("modalFooter.php"); ?>
