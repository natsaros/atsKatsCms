<?php

require_once(CLASSES_ROOT_PATH . 'util' . DS . 'PathHelper.php');

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
        $imagePath = isNotEmpty($post->getImagePath()) ? $post->getImagePath() : $post->getID() . '.jpg';
        $path2post = PICTURES_ROOT . $post->getID() . DS . $imagePath;
        if (!file_exists($path2post)) {
            $imageData = $post->getImage();
            if (isNotEmpty($imageData)) {
                //save image to file system to serve it from there next time
                self::saveImageContentToFile($path2post, $imageData);
                return self::renderImageFromBlob($imageData, $imagePath);
            } else {
                return self::renderImageFromGallery($path2post, 'blog_default.png');
            }
        } else {
            return self::renderImageFromGallery($path2post, 'blog_default.png');
        }
    }

    /**
     * @param User $user
     * @return string
     * @throws SystemException
     */
    static function renderUserImage($user) {
        $imagePath = isNotEmpty($user->getPicturePath()) ? $user->getPicturePath() : $user->getUserName() . '.jpg';
        $path = PICTURES_ROOT . $user->getUserName() . DS . $imagePath;
        if (!file_exists($path)) {
            $imageData = $user->getPicture();
            if (isNotEmpty($imageData)) {
                //save image to file system to serve it from there next time
                self::saveImageContentToFile($path, $imageData);
                return self::renderImageFromBlob($imageData, $imagePath);
            } else {
                return self::renderImageFromGallery($path, 'default.png');
            }
        } else {
            return self::renderImageFromGallery($path, 'default.png');
        }
    }

    /**
     * @param $image
     * @param $imagePath
     * @return string
     * @throws SystemException
     */
    private static function renderImageFromBlob($image, $imagePath) {
        $base64 = base64_encode($image);
        return 'data:' . self::getMimeType($imagePath) . ';base64,' . $base64;
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
        createDirIfNotExists(PathHelper::getParentPath($path));
        return file_put_contents($path, $data);
    }

    /**
     * @param $extraPath
     * @param $tmpFile
     */
    static function saveImageToFileSystem($extraPath, $tmpFile) {
        $pathToSave = PICTURES_ROOT;
        $pathToSave .= isNotEmpty($extraPath) ? $extraPath . DS : '';
        createDirIfNotExists($pathToSave);
        $pathToSave .= $tmpFile[self::NAME];
        move_uploaded_file($tmpFile[self::TMP_NAME], $pathToSave);
    }

    static function removeImageFromFileSystem($path) {
        $pathToDel = PICTURES_ROOT;
        $pathToDel .= $path . '/';
        self::rrmdir($pathToDel);
    }

    static function rrmdir($dir) {
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file)) {
                self::rrmdir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dir);
    }

}