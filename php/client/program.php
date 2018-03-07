<?php
const PILATES_EQUIP = 'Pilates equipment';
const YOGA = 'Yoga';
const PILATES_MAT = 'Pilates mat';
const FAT_BURN = 'Fat burn';
const AERIAL_YOGA = 'Aerial yoga';

const MONDAY = 'monday';
const TUESDAY = 'tuesday';
const WEDNESDAY = 'wednesday';
const THURSDAY = 'thursday';
const FRIDAY = 'friday';
const SATURDAY = 'saturday';

const TIME_FRAME = 'timeframe';
const LESSON = 'lesson';

$weekDaysGr = array(MONDAY => 'Δευτέρα', TUESDAY => 'Τρίτη', WEDNESDAY => 'Τετάρτη', THURSDAY => 'Πέμπτη', FRIDAY => 'Παρασκευή', SATURDAY => 'Σάββατο');
$weekDays = array(MONDAY => MONDAY, TUESDAY => TUESDAY, WEDNESDAY => WEDNESDAY, THURSDAY => THURSDAY, FRIDAY => FRIDAY, SATURDAY => SATURDAY);


/**
 * @param $start
 * @param $end
 * @param $lesson
 * @param string $secondLesson
 * @return array
 */
function addLesson($start, $end, $lesson, $secondLesson = '') {
    $lessonStr = $lesson;
    if ($secondLesson !== '') {
        $lessonStr .= ' / ' . $secondLesson;
    }
    return array(TIME_FRAME => $start . '-' . $end, LESSON => $lessonStr);
}

$program = array(
    array(
        $weekDays[MONDAY] =>
            array(
                addLesson('08:30', '09:30', PILATES_EQUIP),
                addLesson('09:30', '10:30', PILATES_EQUIP),
                addLesson('10:30', '11:30', PILATES_EQUIP),
                addLesson('11:30', '12:30', PILATES_EQUIP),
                addLesson('13:00', '14:00', PILATES_EQUIP),
                addLesson('16:00', '17:00', PILATES_EQUIP),
                addLesson('17:00', '18:00', PILATES_EQUIP),
                addLesson('18:00', '19:00', PILATES_MAT),
                addLesson('19:00', '20:00', FAT_BURN),
                addLesson('20:00', '21:00', YOGA),
                addLesson('21:00', '22:00', PILATES_EQUIP)),
        $weekDays[TUESDAY] =>
            array(
                addLesson('08:30', '09:30', PILATES_EQUIP),
                addLesson('09:00', '10:00', YOGA),
                addLesson('09:30', '10:30', PILATES_EQUIP),
                addLesson('10:30', '11:30', PILATES_MAT),
                addLesson('11:30', '12:30', PILATES_EQUIP),
                addLesson('16:00', '17:00', PILATES_EQUIP),
                addLesson('17:00', '18:00', PILATES_EQUIP),
                addLesson('18:00', '19:00', PILATES_EQUIP),
                addLesson('19:00', '20:00', PILATES_MAT),
                addLesson('20:00', '21:00', PILATES_EQUIP),
                addLesson('21:00', '22:00', PILATES_EQUIP)),
        $weekDays[WEDNESDAY] =>
            array(
                addLesson('08:30', '09:30', PILATES_EQUIP),
                addLesson('09:30', '10:30', PILATES_EQUIP),
                addLesson('10:00', '11:00', FAT_BURN),
                addLesson('10:30', '11:30', PILATES_EQUIP),
                addLesson('13:00', '14:00', PILATES_EQUIP),
                addLesson('16:00', '17:00', PILATES_EQUIP),
                addLesson('17:00', '18:00', PILATES_EQUIP),
                addLesson('18:00', '19:00', PILATES_MAT),
                addLesson('19:00', '20:00', FAT_BURN),
                addLesson('20:00', '21:00', PILATES_MAT, AERIAL_YOGA),
                addLesson('21:00', '22:00', PILATES_EQUIP)),
        $weekDays[THURSDAY] =>
            array(
                addLesson('08:30', '09:30', PILATES_EQUIP),
                addLesson('09:30', '10:30', PILATES_EQUIP),
                addLesson('10:30', '11:30', PILATES_MAT),
                addLesson('17:00', '18:00', PILATES_EQUIP),
                addLesson('18:00', '19:00', PILATES_EQUIP),
                addLesson('19:00', '20:00', YOGA),
                addLesson('20:00', '21:00', PILATES_EQUIP),
                addLesson('21:00', '22:00', PILATES_EQUIP)),
        $weekDays[FRIDAY] =>
            array(
                addLesson('08:30', '09:30', PILATES_EQUIP),
                addLesson('09:30', '10:30', PILATES_EQUIP),
                addLesson('10:30', '11:30', PILATES_EQUIP),
                addLesson('11:30', '12:30', PILATES_EQUIP),
                addLesson('16:00', '17:00', PILATES_EQUIP),
                addLesson('17:00', '18:00', PILATES_EQUIP),
                addLesson('19:00', '20:00', PILATES_MAT),
                addLesson('20:00', '21:00', PILATES_EQUIP)),
        $weekDays[SATURDAY] =>
            array(
                addLesson('10:30', '11:30', PILATES_EQUIP),
                addLesson('11:30', '12:30', PILATES_EQUIP),
                addLesson('13:00', '14:00', PILATES_MAT, AERIAL_YOGA))
    )
);

/**
 * @param $program array
 * @param $weekDaysGr
 */
function renderMobileProgram($program, $weekDaysGr) {
    echo '<div class="timeTable panel-group" id="accordion">';
    foreach ($program as $weekDays) {
        foreach ($weekDays as $day => $timeFrames) {
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
            foreach ($timeFrames as $timeFrame) {
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
    echo '</div>';
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
            <table class="aboutTimeTable table table-responsive">
                <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Δευτέρα</th>
                    <th>Τρίτη</th>
                    <th>Τετάρτη</th>
                    <th>Πέμπτη</th>
                    <th>Παρασκευή</th>
                    <th>Σάββατο</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>08:30 - 09:30</td>
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Δευτέρα-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Τρίτη-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Τετάρτη-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Πέμπτη-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Παρασκευή-->
                    <td>&nbsp;</td>                     <!--Σάββατο-->
                </tr>
                <tr>
                    <td>09:00 - 10:00</td>
                    <td>&nbsp;</td>                     <!--Δευτέρα-->
                    <td><?php echo YOGA ?></td>           <!--Τρίτη-->
                    <td>&nbsp;</td>           <!--Τετάρτη-->
                    <td>&nbsp;</td>           <!--Πέμπτη-->
                    <td>&nbsp;</td>                     <!--Παρασκευή-->
                    <td>&nbsp;</td>                     <!--Σάββατο-->
                </tr>
                <tr>
                    <td>09:30 - 10:30</td>
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Δευτέρα-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Τρίτη-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Τετάρτη-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Πέμπτη-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Παρασκευή-->
                    <td>&nbsp;</td>                     <!--Σάββατο-->
                </tr>
                <tr>
                    <td>10:00 - 11:00</td>
                    <td>&nbsp;</td>                     <!--Δευτέρα-->
                    <td>&nbsp;</td>           <!--Τρίτη-->
                    <td><?php echo FAT_BURN ?></td>           <!--Τετάρτη-->
                    <td>&nbsp;</td>           <!--Πέμπτη-->
                    <td>&nbsp;</td>                     <!--Παρασκευή-->
                    <td>&nbsp;</td>                     <!--Σάββατο-->
                </tr>
                <tr>
                    <td>10:30 - 11:30</td>
                    <td><?php echo PILATES_EQUIP ?></td>          <!--Δευτέρα-->
                    <td><?php echo PILATES_MAT ?></td>               <!--Τρίτη-->
                    <td><?php echo PILATES_EQUIP ?></td>            <!--Τετάρτη-->
                    <td><?php echo PILATES_MAT ?></td>               <!--Πέμπτη-->
                    <td><?php echo PILATES_EQUIP ?></td>          <!--Παρασκευή-->
                    <td><?php echo PILATES_EQUIP ?></td>                    <!--Σάββατο-->
                </tr>
                <tr>
                    <td>11:30 - 12:30</td>
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Δευτέρα-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Τρίτη-->
                    <td>&nbsp;</td>                                <!--Τετάρτη-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Πέμπτη-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Παρασκευή-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Σάββατο-->
                </tr>
                <tr>
                    <td>13:00 - 14:00</td>
                    <td><?php echo PILATES_EQUIP ?></td>                     <!--Δευτέρα-->
                    <td>&nbsp;</td>                     <!--Τρίτη-->
                    <td><?php echo PILATES_EQUIP ?></td>                     <!--Τετάρτη-->
                    <td>&nbsp;</td>                     <!--Πέμπτη-->
                    <td>&nbsp;</td>                     <!--Παρασκευή-->
                    <td><?php echo PILATES_MAT ?>/<?php echo AERIAL_YOGA ?></td>    <!--Σάββατο-->
                </tr>
                <tr>
                    <td>16:00 - 17:00</td>
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Δευτέρα-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Τρίτη-->
                    <td><?php echo PILATES_EQUIP ?></td>                                <!--Τετάρτη-->
                    <td>&nbsp;</td>           <!--Πέμπτη-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Παρασκευή-->
                    <td>&nbsp;</td>           <!--Σάββατο-->
                </tr>
                <tr>
                    <td>17:00 - 18:00</td>
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Δευτέρα-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Τρίτη-->
                    <td><?php echo PILATES_EQUIP ?></td>                     <!--Τετάρτη-->
                    <td><?php echo PILATES_EQUIP ?></td>                     <!--Πέμπτη-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Παρασκευή-->
                    <td>&nbsp;</td>                     <!--Σάββατο-->
                </tr>
                <tr>
                    <td>18:00 - 19:00</td>
                    <td><?php echo PILATES_MAT ?></td>                <!--Δευτέρα-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Τρίτη-->
                    <td><?php echo PILATES_MAT ?></td>                <!--Τετάρτη-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Πέμπτη-->
                    <td>&nbsp;</td>                     <!--Παρασκευή-->
                    <td>&nbsp;</td>                     <!--Σάββατο-->
                </tr>
                <tr>
                    <td>19:00 - 20:00</td>
                    <td><?php echo FAT_BURN ?></td>                <!--Δευτέρα-->
                    <td><?php echo PILATES_MAT ?></td>                <!--Τρίτη-->
                    <td><?php echo FAT_BURN ?></td>                <!--Τετάρτη-->
                    <td><?php echo YOGA ?></td>                       <!--Πέμπτη-->
                    <td><?php echo PILATES_MAT ?></td>           <!--Παρασκευή-->
                    <td>&nbsp;</td>                     <!--Σάββατο-->
                </tr>
                <tr>
                    <td>20:00 - 21:00</td>
                    <td><?php echo YOGA ?></td>            <!--Δευτέρα-->
                    <td><?php echo PILATES_EQUIP ?></td>          <!--Τρίτη-->
                    <td><?php echo PILATES_MAT ?>/<?php echo AERIAL_YOGA ?></td>          <!--Τετάρτη-->
                    <td><?php echo PILATES_EQUIP ?></td>          <!--Πέμπτη-->
                    <td><?php echo PILATES_EQUIP ?></td>          <!--Παρασκευή-->
                    <td>&nbsp;</td>                    <!--Σάββατο-->
                </tr>
                <tr>
                    <td>21:00 - 22:00</td>
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Δευτέρα-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Τρίτη-->
                    <td><?php echo PILATES_EQUIP ?></td>                     <!--Τετάρτη-->
                    <td><?php echo PILATES_EQUIP ?></td>           <!--Πέμπτη-->
                    <td>&nbsp;</td>                     <!--Παρασκευή-->
                    <td>&nbsp;</td>                     <!--Σάββατο-->
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mobile">
        <div class="headerTitle">
            <p>Πρόγραμμα</p>
            <div class="titlesBorder"></div>
        </div>
        <?php renderMobileProgram($program, $weekDaysGr); ?>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="textHolder">
                <div class="textHolderInside">
                    <div class="noteTitle">
                        <p> * Σημείωση</p>
                    </div>

                    <div class="contactInfo">
                        <p>
                            Τα μαθήματα του <strong><?php echo PILATES_EQUIP ?></strong> κλείνονται κατόπιν ραντεβου
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>