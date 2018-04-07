<?php
/**
 * Handles form data
 */

class FormHandler {

    private static $afterFormSubmission = false;
    private static $form_data;

    /**
     * unsets form data from session and initiliazes form_data objects
     *
     * USED IN NAVIGATION SECTIONS
     * @param $formName
     */
    static function unsetSessionForm($formName) {
        if (isset($_SESSION[$formName]) && !empty($_SESSION[$formName])) {
            self::$afterFormSubmission = true;
            self::$form_data = $_SESSION[$formName];
            unset($_SESSION[$formName]);
        }
    }

    /**
     * sets form data to session
     *
     * USED IN ACTION SECTIONS
     * @param $formName
     */
    static function setSessionForm($formName) {
        if (isNotEmpty($_POST)) {
            foreach ($_POST as $key => $value) {
                $_SESSION[$formName][$key] = $value;
            }
        }

        if (isNotEmpty($_FILES)) {
            foreach ($_FILES as $key => $value) {
                $_SESSION[$formName][$key] = $value;
            }
        }
    }

    /**
     * retrieves data from form_data object
     *
     * @param $fieldName
     * @return null|string
     */
    static function getFormData($fieldName) {
        return self::$afterFormSubmission ? self::$form_data[$fieldName] : null;
    }

    /**
     * retrieves data from form_data object
     *
     * @param $fieldName
     * @param $field
     * @return null|string
     */
    static function getEditFormData($fieldName, $field) {
        return self::$afterFormSubmission ? self::$form_data[$fieldName] : $field;
    }
}