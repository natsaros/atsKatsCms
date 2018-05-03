<?php
/**
 * edits a lesson
 */

$lesson = safe_input($_POST[ProgramHandler::LESSON]);
$id = safe_input($_POST[ProgramHandler::ID]);
try {
    $res = ProgramHandler::editLesson($id, $lesson);
    if ($res !== null || $res) {
        addSuccessMessage("Lesson successfully edited");
    } else {
        addErrorMessage("Lesson failed to be edited");
    }
} catch (SystemException $e) {
    logError($e);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}