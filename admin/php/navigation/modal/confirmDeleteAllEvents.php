<?php
/**
 * Confirms deletion of all events
 */
try { ?>
    <?php
    $modalTitle = $_GET['modalTitle'];
    $modalText = $_GET['modalText'];
    ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="deleteAll_events_"><?php echo $modalTitle; ?></h4>
    </div>

    <?php $action = getAdminActionRequestUri() . "events" . DS . "deleteAllEvents"; ?>
    <form name="updateLessonForm" role="form" action="<?php echo $action; ?>" data-toggle="validator" method="post">
        <?php require_safe(ADMIN_NAV_PATH . 'modalMessageSection' . PHP_POSTFIX) ?>
        <div class="modal-body text-center">
            <div class="row">
                <?php echo $modalText; ?>
            </div>
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