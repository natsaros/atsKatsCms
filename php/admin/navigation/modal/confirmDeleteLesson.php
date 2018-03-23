<?php
try { ?>
    <?php
    $modalTitle = $_GET['modalTitle'];
    $modalText = $_GET['modalText'];
    $ID = $_GET['id'];
    $hiddenName = $_GET['hiddenName'];
    ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="confirmModalLabel_<?php echo $ID; ?>"><?php echo $modalTitle; ?></h4>
    </div>

    <?php $action = getAdminActionRequestUri() . "events" . DS . "deleteLesson"; ?>
    <form name="updateLessonForm" role="form" action="<?php echo $action; ?>" data-toggle="validator" method="post">
        <input type="hidden" name="<?php echo $hiddenName; ?>" value="<?php echo $ID; ?>"/>
        <?php require_safe(ADMIN_NAV_PATH . 'modalMessageSection' . PHP_POSTFIX) ?>
        <div class="modal-body text-center">
            <?php echo $modalText; ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input type="submit" name="submit" value="Delete" placeholder="Delete" class="btn btn-danger"/>
        </div>
    </form>
    <?php
} catch (SystemException $e) {
    logError($e);
}
?>