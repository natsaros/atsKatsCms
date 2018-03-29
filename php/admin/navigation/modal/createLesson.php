<?php try { ?>
    <?php $modalTitle = $_GET['modalTitle']; ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel_event_"><?php echo $modalTitle; ?></h4>
    </div>

    <?php $action = getAdminActionRequestUri() . "events" . DS . "addLesson"; ?>
    <form name="updateLessonForm" role="form" action="<?php echo $action; ?>" data-toggle="validator" method="post">
        <?php require_safe(ADMIN_NAV_PATH . 'modalMessageSection' . PHP_POSTFIX) ?>
        <div class="modal-body text-center">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="control-label" for="lesson_input">Lesson</label>
                        <input class="form-control" placeholder="Lesson Name"
                               name="<?php echo ProgramHandler::LESSON ?>" id="lesson_input"
                               value="" required>
                    </div>
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