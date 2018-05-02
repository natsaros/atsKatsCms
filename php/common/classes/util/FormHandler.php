<?php
/**
 * Handles form data
 */

class FormHandler {

    const DRAFT_PATH = 'draft_path';
    const DRAFT_NAME = 'draft_name';
    const TEMP_IMAGE_SAVED_TOKEN = 'tempImageSavedToken';
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

        self::saveTempImage();
    }

    /**
     * save temp image of form while validation error exist
     */
    static function saveTempImage() {
        if (isNotEmpty($_FILES)) {
            foreach ($_FILES as $key => $value) {
                $image2Upload = $_FILES[$key];
                if ($image2Upload['error'] !== UPLOAD_ERR_NO_FILE) {
                    $simpleImage = ImageUtil::readImageContentFromFile($image2Upload);
                    $fileName = $image2Upload[ImageUtil::NAME];
                    $saved = ImageUtil::saveImageToFileSystem(TEMP_PICTURES_ROOT, null, $fileName, $simpleImage);
                    if ($saved) {
                        $formToken = md5(time());
                        $_SESSION[self::TEMP_IMAGE_SAVED_TOKEN] = $formToken;
                        $_SESSION[$formToken][$key] = $value;
                        $_SESSION[$formToken][$key][self::DRAFT_NAME] = $fileName;
                        $_SESSION[$formToken][$key][self::DRAFT_PATH] = TEMP_PICTURES_ROOT . DS . $fileName;
                    }
                }
            }
        }
    }

    /**
     * determines if picture is save to temp for use in form submission
     *
     * @return bool
     */
    static function isTempPictureSaved() {
        return isNotEmpty($_SESSION[self::TEMP_IMAGE_SAVED_TOKEN]);
    }

    /**
     * returns the token created at temp picture save process
     *
     * @return string
     */
    static function getTempPictureToken() {
        return $_SESSION[self::TEMP_IMAGE_SAVED_TOKEN];
    }

    static function getFormPictureData($key) {
        return $_SESSION[self::getTempPictureToken()][$key];
    }

    static function getFormPictureDraftName($key) {
        return $_SESSION[self::getTempPictureToken()][$key][self::DRAFT_NAME];
    }

    static function getFormPictureDraftPath($key) {
        return $_SESSION[self::getTempPictureToken()][$key][self::DRAFT_PATH];
    }

    static function unsetFormSessionToken() {
        unset($_SESSION[self::getTempPictureToken()]);
        unset($_SESSION[self::TEMP_IMAGE_SAVED_TOKEN]);
        ImageUtil::removeImageFromFileSystem(TEMP_PICTURES_ROOT);
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
     * retrieves data from form_data object with fallback option
     *
     * @param $fieldName
     * @param $field
     * @return null|string
     */
    static function getEditFormData($fieldName, $field) {
        return self::$afterFormSubmission ? self::$form_data[$fieldName] : $field;
    }
}