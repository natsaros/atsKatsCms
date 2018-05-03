<?php
/**
 * this function deletes an event
 */

$id = $_POST['id'];

try {
    $event = ProgramHandler::fetchEventById($id);
    if (isNotEmpty($event)) {
        $deleteEventRes = ProgramHandler::deleteDBEvent($id);
        if ($deleteEventRes !== null || $deleteEventRes) {
            echo json_encode(array('message' => 'SUCCESS', 'description' => 'Lesson deleted successfully'));
        } else {
            throwJSONError();
        }
    } else {
        throwJSONError();
    }
} catch (SystemException $ex) {
    logError($ex);
    throwJSONError();
}

function throwJSONError() {
    $statusCode = 500;
    $status_string = $statusCode . ' ' . 'Internal Server Error';
    header($_SERVER['SERVER_PROTOCOL'] . ' ' . $status_string, true, $statusCode);
    echo json_encode(array('message' => 'ERROR', 'description' => 'Something went wrong'));
}