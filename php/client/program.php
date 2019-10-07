<?php
const MONDAY = DaysOfWeek::MONDAY;
const TUESDAY = DaysOfWeek::TUESDAY;
const WEDNESDAY = DaysOfWeek::WEDNESDAY;
const THURSDAY = DaysOfWeek::THURSDAY;
const FRIDAY = DaysOfWeek::FRIDAY;
const SATURDAY = DaysOfWeek::SATURDAY;

const TIME_FRAME = 'timeframe';
const LESSON = 'lesson';

$events = ProgramHandler::fetchActiveEventsGrouped();
$lessonsPerDay = ProgramHandler::countActiveEventsPerDay();

$mobileProgram = ProgramHandler::mobileProgram($events);
$lessons = ProgramHandler::getLessonsTimeFrames($events);
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
 * @param $lessons Lesson[]
 * @param $lessonsPerDay LessonsPerDay[]
 */
function renderDesktopProgram($lessons, $lessonsPerDay) {
    echo '<tr>';
    echo '<td>' . ProgramHandler::PILATES_EQUIP . '</td>';
    echo '<td colspan="6">' . '08:00 - 13:00 (διάρκεια μαθήματος 1 ωρα) <br> 17:00 - 22:00 (διάρκεια μαθήματος 1 ωρα)' . '</td>';
    echo '</tr>';

    foreach (array_keys($lessons) as $lessonName) {
        echo '<tr>';
        echo '<td>' . $lessonName . '</td>';
        echo '<td>' . getDesktopLesson($lessons, DaysOfWeek::MONDAY, $lessonName) . '</td>';
        echo '<td>' . getDesktopLesson($lessons, DaysOfWeek::TUESDAY, $lessonName) . '</td>';
        echo '<td>' . getDesktopLesson($lessons, DaysOfWeek::WEDNESDAY, $lessonName) . '</td>';
        echo '<td>' . getDesktopLesson($lessons, DaysOfWeek::THURSDAY, $lessonName) . '</td>';
        echo '<td>' . getDesktopLesson($lessons, DaysOfWeek::FRIDAY, $lessonName) . '</td>';
        if (countLessonsPerDay($lessonsPerDay, DaysOfWeek::SATURDAY) > 0) {
            echo '<td>' . getDesktopLesson($lessons, DaysOfWeek::SATURDAY, $lessonName) . '</td>';
        }
        echo '</tr>';
    }
}

/**
 * @param  $weekDays array
 * @param $lessonsPerDay LessonsPerDay[]
 */
function renderWeekDays($weekDays, $lessonsPerDay) {
    foreach (array_keys($weekDays) as $day) {
        if (countLessonsPerDay($lessonsPerDay, $day) > 0) {
            echo '<th>' . $weekDays[$day] . '</th>';
        }
    }
}


/**
 * @param $countLessonsPerDay LessonsPerDay[]
 * @param $day
 * @return mixed
 */
function countLessonsPerDay($countLessonsPerDay, $day) {
    $lessonsPerDayArray = array();
    foreach ($countLessonsPerDay as $item) {
        $lessonsPerDayArray[$item->getDay()] = $item->getCount();
    }

    return $lessonsPerDayArray[$day] !== null ? $lessonsPerDayArray[$day] : 0;
}

function getDesktopLesson($lessons, $day, $lesson) {
    $ret = '';
    $hoursPerDay = $lessons[$lesson][$day];

    if (isNotEmpty($hoursPerDay)) {
        foreach ($hoursPerDay as $i => $timeFrame) {
            if ($i + 1 == count($hoursPerDay)) {
                $ret .= $timeFrame;
            } else {
                $ret .= $timeFrame . '<br>';
            }
        }
        return $ret;
    }

    return '&nbsp;';
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
                    <?php renderWeekDays($weekDaysGr, $lessonsPerDay); ?>
                </tr>
                </thead>
                <tbody>
                <?php renderDesktopProgram($lessons, $lessonsPerDay); ?>
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