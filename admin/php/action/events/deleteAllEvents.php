<?php
/**
 * this function deletes all events
 */

try {
    $res = ProgramHandler::deleteDBEvents();
    if ($res !== null || $res) {
        addSuccessMessage("Lessons successfully deleted");
    } else {
        addErrorMessage("Lessons failed to be deleted");
    }
} catch (SystemException $ex) {
    logError($e);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}