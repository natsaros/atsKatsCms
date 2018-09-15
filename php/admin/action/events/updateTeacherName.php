<?php
/**
 * this function updates a draft event on db
 */

$id = $_POST[ProgramHandler::ID];
$owner = $_POST[ProgramHandler::OWNER];

try {
    $event = ProgramHandler::fetchEventById($id);
    if (isNotEmpty($event)) {
        $event
            ->setOwner($owner);
        $updateEventRes = ProgramHandler::updateDBEventOwner($event);

        if ($updateEventRes !== null || $updateEventRes) {
            echo json_encode($event);
        } else {
            throwJSONError();
        }
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