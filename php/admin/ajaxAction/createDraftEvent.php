<?php
/**
 * this function add an event
 */

$day = $_POST['day'];
$start = $_POST['start'];
$end = $_POST['end'];
$title = $_POST['title'];

try {
    $event = Event::createEvent(null, $title, null, EventStatus::INACTIVE, $day, $start, $end);
    $res = ProgramHandler::addDBEvent($event);
    if ($res !== null || $res) {
        echo json_encode($event);
    } else {
        throwJSONError();
    }

} catch (SystemException $e) {
    logError($ex);
    throwJSONError();
}

function throwJSONError() {
    $statusCode = 500;
    $status_string = $statusCode . ' ' . 'Internal Server Error';
    header($_SERVER['SERVER_PROTOCOL'] . ' ' . $status_string, true, $statusCode);
    echo json_encode(array('message' => 'ERROR', 'code' => 'wroooong'));
}