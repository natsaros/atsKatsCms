<?php

/**
 * Used to facilitate image related functions
 */
class ImageUtil {

    /**
     * @param $name
     * @return string
     * @throws SystemException
     */
    static function renderBlogImage($name) {
        return self::renderImageFromGallery($name, 'conceito-pilates.jpg');
    }

    /**
     * @param $name
     * @return string
     * @throws SystemException
     */
    static function renderUserImage($name) {
        return self::renderImageFromGallery($name, 'default.png');
    }

    /**
     * @param $name
     * @param $fallBack
     * @return string
     * @throws SystemException
     */
    static function renderImageFromGallery($name, $fallBack) {
        $allowedTypes = [];
        if(isNotEmpty(ALLOWED_TYPES)) {
            $allowedTypes = explode('|', ALLOWED_TYPES);
        }

        $mimes = [];
        foreach($allowedTypes as $type) {
            $mimes[$type] = 'image/' . $type;
        }

        if(isNotEmpty($name)) {
            $tmp = explode('.', $name);
            $ext = strtolower(end($tmp));
        } else {
            $tmp = explode('.', $fallBack);
            $ext = strtolower(end($tmp));
        }

        $file = PICTURES_ROOT . $name;
        if(is_dir($file) || !file_exists($file)) {
            $file = PICTURES_ROOT . $fallBack;
        }

        $content = file_get_contents($file);
        $base64 = base64_encode($content);
        return 'data:' . $mimes[$ext] . ';base64,' . $base64;
    }

    /**
     * @param $image
     * @return boolean
     * @throws SystemException
     */
    static function validateImageAllowed($image) {
        $allowedTypes = [];
        if(isNotEmpty(ALLOWED_TYPES)) {
            $allowedTypes = explode('|', ALLOWED_TYPES);
        }
        $fileType = explode('/', $image['type'])[1];

        return in_array($fileType, $allowedTypes);
    }

}