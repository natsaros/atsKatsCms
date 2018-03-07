<?php
const PILATES_EQUIP = 'Pilates equipment';
const YOGA = 'Yoga';
const PILATES_MAT = 'Pilates mat';
const FAT_BURN = 'Fat burn';
const AERIAL_YOGA = 'Aerial yoga';

const MONDAY = 'Monday';
const TUESDAY = 'Tuesday';
const WEDNESDAY = 'Wednesday';
const THURSDAY = 'Thursday';
const FRIDAY = 'Friday';
const SATURDAY = 'Saturday';

const TIME_FRAME = 'timeframe';
const LESSON = 'lesson';

$weekDays = array(MONDAY => MONDAY, TUESDAY => TUESDAY, WEDNESDAY => WEDNESDAY, THURSDAY => THURSDAY, FRIDAY => FRIDAY, SATURDAY => SATURDAY);
$timeFrames = array('08:30-09:30', '09:00-10:00', '09:30-10:30', '10:00-11:00',
    '10:30-11:30', '11:30-12:30', '13:00-14:00', '16:00-17:00',
    '17:00-18:00', '18:00-19:00', '19:00-20:00', '20:00-21:00',
    '21:00-22:00');


$program = array(
    array(
        $weekDays[MONDAY] =>
            array(
                array(TIME_FRAME => $timeFrames[0], LESSON => PILATES_MAT),
                array(TIME_FRAME => $timeFrames[1], LESSON => PILATES_EQUIP)),
        $weekDays[TUESDAY] =>
            array(
                array(TIME_FRAME => $timeFrames[0], LESSON => PILATES_EQUIP),
                array(TIME_FRAME => $timeFrames[1], LESSON => AERIAL_YOGA)))
);


$json = json_encode($program);

/**
 * @param $program array
 */
function renderMobileProgram($program) {
//    TODO : render program correctly

    echo '<div class="timeTable panel-group" id="accordion">';
    foreach ($program as $weekDays) {
        echo '<table class="table table-hover">';
        echo '<tbody>';

        foreach ($weekDays as $timeFrames) {
            echo '<tr>';
            foreach ($timeFrames as $timeFrame) {
                echo '<td>' . $timeFrame[TIME_FRAME] . '</td>';
                echo '<td>' . $timeFrame[LESSON] . '</td>';
            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
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
        <div class="timeTable panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#monday">Δευτέρα</a>
                    </h4>
                </div>
                <div id="monday" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td>08:30 - 09:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>09:30 - 10:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>10:30 - 11:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>11:30 - 12:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>13:00 - 14:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>16:00 - 17:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>17:00 - 18:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>18:00 - 19:00</td>
                                <td><?php echo PILATES_MAT ?></td>
                            </tr>
                            <tr>
                                <td>19:00 - 20:00</td>
                                <td><?php echo FAT_BURN ?></td>
                            </tr>
                            <tr>
                                <td>20:00 - 21:00</td>
                                <td><?php echo YOGA ?></td>
                            </tr>
                            <tr>
                                <td>21:00 - 22:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#tuesday">Τρίτη</a>
                    </h4>
                </div>
                <div id="tuesday" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td>08:30 - 09:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>09:00 - 10:00</td>
                                <td><?php echo YOGA ?></td>
                            </tr>
                            <tr>
                                <td>09:30 - 10:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>10:30 - 11:30</td>
                                <td><?php echo PILATES_MAT ?></td>
                            </tr>
                            <tr>
                                <td>11:30 - 12:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>16:00 - 17:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>17:00 - 18:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>18:00 - 19:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>19:00 - 20:00</td>
                                <td><?php echo PILATES_MAT ?></td>
                            </tr>
                            <tr>
                                <td>20:00 - 21:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>21:00 - 22:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#wednesday">Τετάρτη</a>
                    </h4>
                </div>
                <div id="wednesday" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td>08:30 - 09:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>09:30 - 10:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>10:00 - 11:00</td>
                                <td><?php echo FAT_BURN ?></td>
                            </tr>
                            <tr>
                                <td>10:30 - 11:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>13:00 - 14:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>16:00 - 17:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>17:00 - 18:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>18:00 - 19:00</td>
                                <td><?php echo PILATES_MAT ?></td>
                            </tr>
                            <tr>
                                <td>19:00 - 20:00</td>
                                <td><?php echo FAT_BURN ?></td>
                            </tr>
                            <tr>
                                <td>20:00 - 21:00</td>
                                <td><?php echo PILATES_MAT ?>/<?php echo AERIAL_YOGA ?></td>
                            </tr>
                            <tr>
                                <td>21:00 - 22:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#thursday">Πέμπτη</a>
                    </h4>
                </div>
                <div id="thursday" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td>08:30 - 09:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>09:30 - 10:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>10:30 - 11:30</td>
                                <td><?php echo PILATES_MAT ?></td>
                            </tr>
                            <tr>
                                <td>17:00 - 18:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>18:00 - 19:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>19:00 - 20:00</td>
                                <td><?php echo YOGA ?></td>
                            </tr>
                            <tr>
                                <td>20:00 - 21:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>21:00 - 22:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#friday">Παρασκευή</a>
                    </h4>
                </div>
                <div id="friday" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td>08:30 - 09:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>09:30 - 10:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>10:30 - 11:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>11:30 - 12:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>16:00 - 17:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>17:00 - 18:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>19:00 - 20:00</td>
                                <td><?php echo PILATES_MAT ?></td>
                            </tr>
                            <tr>
                                <td>20:00 - 21:00</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#saturday">Σάββατο</a>
                    </h4>
                </div>
                <div id="saturday" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td>10:30 - 11:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>11:30 - 12:30</td>
                                <td><?php echo PILATES_EQUIP ?></td>
                            </tr>
                            <tr>
                                <td>13:00 - 14:00</td>
                                <td><?php echo PILATES_MAT ?>/<?php echo AERIAL_YOGA ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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