<?php require(ADMIN_NAV_PATH . "pageHeader.php"); ?>

<?php require(ADMIN_NAV_PATH . "messageSection.php"); ?>

<?php
$lessons = ProgramHandler::fetchLessons();
$rawEvents = ProgramHandler::fetchEvents();

$events = json_encode($rawEvents);
?>
<div class="row">
    <div class="col-lg-2 text-center">
        <div class="alert text-center alert-info fade in">
            Drag classes on calendar to add new lesson
        </div>
        <div id='external-events'>
            <div id='external-events-listing'>
                <h4>Classes</h4>

                <?php
                $hiddenName = ProgramHandler::ID;
                /* @var $lesson Lesson */
                foreach ($lessons as $lesson) { ?>
                    <div class="fc-event-container">
                        <div class="fc-event fc-lesson"><?php echo $lesson->getName() ?></div>
                        <?php $ID = $lesson->getID(); ?>
                        <?php
                        $modalTitle = "Edit Class";
                        $urlParams = addParamsToUrl(
                            array('modalTitle', 'id', 'hiddenName'),
                            array(urlencode($modalTitle), $ID, $hiddenName)); ?>
                        <a type="button"
                           data-toggle="modal"
                           class="btn btn-default btn-sm" title="<?php echo $modalTitle; ?>"
                           href="<?php echo getAdminModalRequestUri() . "editLesson" . $urlParams; ?>"
                           data-target="#editModal_<?php echo $ID; ?>"
                           data-remote="false">
                            <span class="fa fa-pencil" aria-hidden="true"></span>
                        </a>

                        <?php
                        $modalTitle = "Delete Class";
                        $modalText = "You are about to delete a class. Are you sure?";
                        $urlParams = addParamsToUrl(
                            array('modalTitle', 'modalText', 'id', 'hiddenName'),
                            array(urlencode($modalTitle), urlencode($modalText), $ID, $hiddenName)) ?>
                        <a type="button"
                           data-toggle="modal"
                           class="btn btn-default btn-sm" title="<?php echo $modalTitle; ?>"
                           href="<?php echo getAdminModalRequestUri() . "confirmDeleteLesson" . $urlParams; ?>"
                           data-target="#confirmModal_<?php echo $ID; ?>"
                           data-remote="false">
                            <span class="fa fa-minus" aria-hidden="true"></span>
                        </a>
                    </div>
                <?php } ?>
            </div>

            <?php
            /* @var $lesson Lesson */
            foreach ($lessons as $lesson) {
                $ID = $lesson->getID();
                ?>
                <div class="ak_modal modal fade" id="confirmModal_<?php echo $ID; ?>"
                     tabindex="-1"
                     role="dialog" aria-labelledby="confirmModalLabel_<?php echo $ID; ?>"
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content"></div>
                    </div>
                </div>

                <div class="ak_modal modal fade" id="editModal_<?php echo $ID; ?>"
                     tabindex="-1"
                     role="dialog" aria-labelledby="editModalLabel_<?php echo $ID; ?>"
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content"></div>
                    </div>
                </div>
            <?php } ?>

            <!-- Button trigger modal -->
            <?php
            $modalTitle = "Add Class";
            $urlParams = addParamsToUrl(array('modalTitle'), array(urlencode($modalTitle))) ?>
            <a type="button"
               data-toggle="modal"
               class="btn btn-default btn-block btn-m" title="<?php echo $modalTitle; ?>"
               href="<?php echo getAdminModalRequestUri() . "createLesson" . $urlParams; ?>"
               data-target="#eventModal_"
               data-remote="false">
                <span class="fa fa-plus" aria-hidden="true"></span>
            </a>

            <!-- Modal-->
            <div class="ak_modal modal fade" id="eventModal_"
                 tabindex="-1"
                 role="dialog" aria-labelledby="myModalLabel_event_"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-10">
        <?php $action = getAdminActionRequestUri() . "events" . DS . "saveEvents"; ?>
        <form name="saveProgramForm" role="form" action="<?php echo $action; ?>" data-toggle="validator" method="post"
              enctype="multipart/form-data">
            <div class="alert text-center alert-info alert-dismissable fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Click on lesson to view details and actions.
                Move or resize lessons on calendar to change time.
                <strong>Remember!</strong> You need to always save your changes to take effect on front end side
            </div>
            <div class="panel-body">
                <div id="calendar"></div>
            </div>
            <div class="text-right form-group">
                <?php
                $modalTitle = "Delete All Classes";
                $modalText = "You are about to delete all classes. Are you sure?";
                $urlParams = addParamsToUrl(array('modalTitle', 'modalText'), array(urlencode($modalTitle), urlencode($modalText))) ?>
                <a type="button"
                   data-toggle="modal"
                   href="<?php echo getAdminModalRequestUri() . 'confirmDeleteAllEvents' . $urlParams ?>"
                   class="btn btn-default"
                   title="Delete All"
                   data-target="#deleteAllModal_"
                   data-remote="false"
                >Delete All</a>

                <input type="submit" name="submit" class="btn btn-primary" value="Save" placeholder="Save"/>

            </div>
        </form>
    </div>

    <!-- Modal-->
    <div class="ak_modal modal fade" id="deleteAllModal_"
         tabindex="-1"
         role="dialog" aria-labelledby="deleteAll_events_"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

    <!-- Modal-->
    <div id="eventContent" class="ak_modal modal fade"
         tabindex="-1"
         role="dialog" aria-labelledby="eventContent_title"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="eventContent_title">Lesson Details</h4>
                </div>
                <?php $action = getAdminActionRequestUri() . "events" . DS . "updateTeacherName"; ?>
                <form name="saveTeacherForm" role="form" action="<?php echo $action; ?>" data-toggle="validator"
                      method="post">
                    <div class="modal-body text-center">
                        <input id="hiddenID" type="hidden" name="<?php echo ProgramHandler::ID; ?>" value=""/>
                        <div class="row">
                            <div class="col-lg-12">
                                Start: <span id="startTime"></span><br>
                                End: <span id="endTime"></span><br><br>
                                <p id="eventInfo"></p>
                                <div class="modal-body text-center">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label" for="lesson_input">Teacher</label>
                                                <input class="form-control" placeholder="Teacher Name"
                                                       name="<?php echo ProgramHandler::OWNER ?>" id="lesson_input"
                                                       value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deleteBtn" type="button" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" name="submit" value="Save" placeholder="Save" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    var $calendar = $('#calendar');
    $(function () {
        init(<?php echo $events;?>, $calendar);
    });
</script>