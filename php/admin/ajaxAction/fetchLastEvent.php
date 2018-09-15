<?php
try {
    $rawEvent = ProgramHandler::fetchLastEvent();
    if ($rawEvent) {
        echo json_encode($rawEvent);
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