<?php

/**
 * Used to facilitate image related functions
 */
class ImageUtil {

    const TMP_NAME = 'tmp_name';
    const NAME = 'name';

    /**
     * @param Post $post
     * @return string
     * @throws SystemException
     */
    static function renderBlogImage($post) {
        $path2post = PICTURES_ROOT . $post->getID() . DS . $post->getImagePath();
        if (!file_exists($path2post)) {
            if (isNotEmpty($post->getImage())) {

                //save image to file system to serve it from there next time
                self::saveImageContentToFile($path2post,$post->getImage());
                return self::renderImageFromBlob($post);
            } else {
                return self::renderImageFromGallery($path2post, 'blog_default.png');
            }
        } else {
            return self::renderImageFromGallery($path2post, 'blog_default.png');
        }
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
     * @param Post $post
     * @return string
     * @throws SystemException
     */
    private static function renderImageFromBlob($post) {
        $base64 = base64_encode($post->getImage());
        return 'data:' . self::getMimeType($post->getImagePath()) . ';base64,' . $base64;
    }

    /**
     * @param $path
     * @param $fallBack
     * @return string
     * @throws SystemException
     */
    static function renderImageFromGallery($path, $fallBack) {
        if (is_dir($path) || !file_exists($path)) {
            $path = PICTURES_ROOT . $fallBack;
        }
        $content = file_get_contents($path);
        $base64 = base64_encode($content);
        return 'data:' . self::getMimeType($path) . ';base64,' . $base64;
    }

    private static function getMimeType($fileName) {
        $allowedTypes = [];
        if (isNotEmpty(ALLOWED_TYPES)) {
            $allowedTypes = explode('|', ALLOWED_TYPES);
        }

        $mimes = [];
        foreach ($allowedTypes as $type) {
            $mimes[$type] = 'image/' . $type;
        }

        $tmp = explode('.', $fileName);
        $ext = strtolower(end($tmp));

        return $mimes[$ext];
    }

    /**
     * @param $image
     * @return boolean
     * @throws SystemException
     */
    static function validateImageAllowed($image) {
        $allowedTypes = [];
        if (isNotEmpty(ALLOWED_TYPES)) {
            $allowedTypes = explode('|', ALLOWED_TYPES);
        }
        $fileType = explode('/', $image['type'])[1];

        return in_array($fileType, $allowedTypes);
    }

    /**
     * @param $tmpFile
     * @return bool|string
     */
    static function readImageContentFromFile($tmpFile) {
        $tmpFileContent = $tmpFile[self::TMP_NAME];
//        $fp = fopen($tmpFileContent, 'r');  // open a file handle of the temporary file
//        $imgContent = fread($fp, filesize($tmpFileContent)); // read the temp file
//        fclose($fp); // close the file handle

        $imgContent = file_get_contents($tmpFileContent);
        return $imgContent;
    }

    /**
     * @param $path
     * @param $data
     * @return bool|string
     */
    static function saveImageContentToFile($path, $data) {
        return file_put_contents($path, $data);
    }

    static function saveImageToFileSystem($extraPath, $tmpFile) {
        $pathToSave = PICTURES_ROOT;
        $pathToSave .= isNotEmpty($extraPath) ? $extraPath . DS : '';
        createFileIfNotExists($pathToSave);
        $pathToSave .= $tmpFile[self::NAME];
        move_uploaded_file($tmpFile[self::TMP_NAME], $pathToSave);
    }

}