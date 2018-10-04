<?php
/**
 * adds new lesson
 */

$lesson = safe_input($_POST[ProgramHandler::LESSON]);
try {
    $res = ProgramHandler::addDBLesson($lesson);
    if ($res !== null || $res) {
        addSuccessMessage("Lesson successfully added");
    } else {
        addErrorMessage("Lesson failed to be added");
    }
} catch (SystemException $e) {
    logError($e);
    addErrorMessage(ErrorMessages::GENERIC_ERROR);
}