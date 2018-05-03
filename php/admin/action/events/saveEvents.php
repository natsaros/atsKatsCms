<?php
/**
 * This functions saves all draft lessons
 */
try {
    $res = ProgramHandler::saveDBEvents();
    if ($res !== null || $res) {
        addSuccessMessage("Lessons successfully saved");
    } else {
        addErrorMessage("Lessons failed to be saved");
    }

    Redirect(getAdminRequestUri() . PageSections::PROGRAM . DS . "program");
} catch (SystemException $ex) {
    logError($e);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}