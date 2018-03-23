<?php require("pageHeader.php"); ?>

<?php require("messageSection.php"); ?>

<style>
    #external-events .fc-event {
        margin: 10px 0;
        padding: 6px 10px;
        cursor: pointer;
    }

    .published {
        background-color: #20BB2A;
        border: 1px solid #20BB2A;
    }

    .fc-event-container > * {
        display: inline-block;
    }

    .fc-lesson {
        width: 70%;
    }
</style>

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
        <div class="panel-body">
            <div id="calendar"></div>
        </div>
    </div>
    <!-- Modal-->
    <div id="eventContent" class="ak_modal modal fade"
         tabindex="-1"
         role="dialog" aria-labelledby="eventContent_title"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="eventContent_title">Lesson Details</h4>
                </div>
                <div class="modal-body text-center">
                    <div class="col-lg-12">
                        Start: <span id="startTime"></span><br>
                        End: <span id="endTime"></span><br><br>
                        <p id="eventInfo"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">

    var $external = $('#external-events');

    $external.find('.fc-event')
        .each(function () {
            var externalEvents = {
                title: $.trim($(this).text())
            }; // creating event object and makes event text as its title

            $(this).data('event', externalEvents); //saving events into DOM


            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true, // will cause the event to go back to its
                revertDuration: 0 //  original position after the drag
            });
        });


    window.mobilecheck = function () {
        var check = false;
        (function (a) {
            if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
        })(navigator.userAgent || navigator.vendor || window.opera);
        return check;
    };

    var draftColor = '#3a87ad';
    var $calendar = $('#calendar');

    $calendar.fullCalendar({
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        defaultView: window.mobilecheck() ? 'agendaDay' : 'agendaWeek',
        header: window.mobilecheck() ? {
            left: '',
            center: 'prev,next',
            right: ''
        } : false,
        allDayDefault: false,
        allDaySlot: false,
        defaultTimedEventDuration: '01:00:00',
        forceEventDuration: true,

        editable: true,
        droppable: true,
        dragRevertDuration: 0,

        eventLimit: true, // allow "more" link when too many events
        hiddenDays: [0],
        slotMinutes: 60,
        minTime: "08:00:00",
        slotLabelFormat: "HH:mm",
        timeFormat: "HH:mm",
        columnFormat: 'dddd',
        height: 'auto',
        nowIndicator: true,
        events: <?php echo $events;?>,
        drop: function (date, jsEvent, ui, resourceId) {
            console.log('drop events');
        },
        eventDrop: function (event, delta, revertFunc, jsEvent, ui, view) {
            console.log('eventDrop event : ' + event.id);
            event.color = draftColor;
            $calendar.fullCalendar('updateEvent', event);
        },
        eventResize: function (event, delta, revertFunc, jsEvent, ui, view) {
            event.color = draftColor;
            $calendar.fullCalendar('updateEvent', event);
        },
        eventClick: function (event, jsEvent, view) {
            console.log('event clicked' + event.id);
            $("#startTime").html(moment(event.start).format('MMM Do H:mm A'));
            $("#endTime").html(moment(event.end).format('MMM Do H:mm A'));
            $("#eventInfo").html(event.title);
            $("#eventContent").modal('show');
        },
        eventRender: function (event, element, view) {
            if (event.status === 1) {
                element.addClass('published');
            }
        }
    });
</script>