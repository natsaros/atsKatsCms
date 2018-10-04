<?php
/**
 * deletes lesson
 */

$id = safe_input($_POST[ProgramHandler::ID]);
try {
    $res = ProgramHandler::deleteLesson($id);
    if ($res !== null || $res) {
        addSuccessMessage("Lesson successfully deleted");
    } else {
        addErrorMessage("Lesson failed to be deleted");
    }
} catch (SystemException $e) {
    logError($e);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}