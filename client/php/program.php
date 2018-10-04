<?php
const MONDAY = DaysOfWeek::MONDAY;
const TUESDAY = DaysOfWeek::TUESDAY;
const WEDNESDAY = DaysOfWeek::WEDNESDAY;
const THURSDAY = DaysOfWeek::THURSDAY;
const FRIDAY = DaysOfWeek::FRIDAY;
const SATURDAY = DaysOfWeek::SATURDAY;

const TIME_FRAME = 'timeframe';
const LESSON = 'lesson';
const DAY = 'day';

$events = ProgramHandler::fetchActiveEvents();

$mobileProgram = ProgramHandler::mobileProgram($events);
$lessons = ProgramHandler::desktopProgram($events);
$timeFrames = ProgramHandler::getTimeFrames($events);

$weekDaysGr = array(MONDAY => 'Δευτέρα', TUESDAY => 'Τρίτη', WEDNESDAY => 'Τετάρτη', THURSDAY => 'Πέμπτη', FRIDAY => 'Παρασκευή', SATURDAY => 'Σάββατο');
$weekDays = array(MONDAY => MONDAY, TUESDAY => TUESDAY, WEDNESDAY => WEDNESDAY, THURSDAY => THURSDAY, FRIDAY => FRIDAY, SATURDAY => SATURDAY);

/**
 * @param $program array
 * @param $weekDaysGr array
 */
function renderMobileProgram($program, $weekDaysGr) {
    if (isNotEmpty($program)) {
        foreach ($program as $day => $weekDay) {
            $collapseClass = MONDAY === $day ? ' in' : '';
            echo '<div class="panel panel-default">';
            echo '<div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#' . $day . '">' . $weekDaysGr[$day] . '</a>
                    </h4>
                </div>
                 <div id="' . $day . '" class="panel-collapse collapse' . $collapseClass . '">
                    <div class="panel-body">';
            echo '<table class="table table-hover">';
            echo '<tbody>';
            foreach ($weekDay as $timeFrame) {
                echo '<tr>';
                echo '<td>' . $timeFrame[TIME_FRAME] . '</td>';
                echo '<td>' . $timeFrame[LESSON] . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
}

/**
 * @param $lessons array
 * @param $timeFrames array
 */
function renderDesktopProgram($lessons, $timeFrames) {
    foreach ($timeFrames as $timeFrame) {
        echo '<tr>';
        echo '<td>' . $timeFrame . '</td>';
        echo '<td>' . getDesktopLesson($lessons, DaysOfWeek::MONDAY . '_' . $timeFrame) . '</td>';
        echo '<td>' . getDesktopLesson($lessons, DaysOfWeek::TUESDAY . '_' . $timeFrame) . '</td>';
        echo '<td>' . getDesktopLesson($lessons, DaysOfWeek::WEDNESDAY . '_' . $timeFrame) . '</td>';
        echo '<td>' . getDesktopLesson($lessons, DaysOfWeek::THURSDAY . '_' . $timeFrame) . '</td>';
        echo '<td>' . getDesktopLesson($lessons, DaysOfWeek::FRIDAY . '_' . $timeFrame) . '</td>';
        echo '<td>' . getDesktopLesson($lessons, DaysOfWeek::SATURDAY . '_' . $timeFrame) . '</td>';
        echo '</tr>';
    }
}

function getDesktopLesson($lessons, $key) {
    return isNotEmpty($lessons[$key]) ? $lessons[$key] : '&nbsp;';
}

?>
<div class="container-fluid belowHeader text-center">
    <div class="row row-no-padding">
        <div class="col-sm-12">
            <div class="heroHeader programHero">
                <div class="headerTitle">
                    <p>&nbsp;</p>
                    <div class="titlesBorder invisible"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container timeTableContainer text-center">
    <div class="row desktop">
        <div class="headerTitle">
            <p>Πρόγραμμα</p>
            <div class="titlesBorder"></div>
        </div>
        <div class="col-sm-12">
            <table class="aboutTimeTable table table-responsive text-center">
                <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th><?php echo $weekDaysGr[DaysOfWeek::MONDAY]; ?></th>
                    <th><?php echo $weekDaysGr[DaysOfWeek::TUESDAY]; ?></th>
                    <th><?php echo $weekDaysGr[DaysOfWeek::WEDNESDAY]; ?></th>
                    <th><?php echo $weekDaysGr[DaysOfWeek::THURSDAY]; ?></th>
                    <th><?php echo $weekDaysGr[DaysOfWeek::FRIDAY]; ?></th>
                    <th><?php echo $weekDaysGr[DaysOfWeek::SATURDAY]; ?></th>
                </tr>
                </thead>
                <tbody>
                <?php renderDesktopProgram($lessons, $timeFrames); ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mobile">
        <div class="headerTitle">
            <p>Πρόγραμμα</p>
            <div class="titlesBorder"></div>
        </div>
        <div class="timeTable panel-group" id="accordion">
            <?php renderMobileProgram($mobileProgram, $weekDaysGr); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="textHolder" style="height: 200px;">
                <div class="textHolderInside">
                    <div class="noteTitle">
                        <p> * Σημείωση</p>
                    </div>

                    <div class="contactInfo">
                        <p>
                            Τα μαθήματα του <strong><?php echo ProgramHandler::PILATES_EQUIP ?></strong> κλείνονται
                            κατόπιν ραντεβου
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>