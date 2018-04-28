<?php

require_once(CLASSES_ROOT_PATH . 'util' . DS . 'PathHelper.php');
require_once(CLASSES_ROOT_PATH . 'util' . DS . 'SimpleImage.php');

/**
 * Used to facilitate image related functions
 */
class ImageUtil {

    const TMP_NAME = 'tmp_name';
    const NAME = 'name';

    /**
     * @param ProductCategory $productCategory
     * @return string
     * @throws SystemException
     */
    static function renderProductCategoryImage($productCategory) {
        $imagePath = isNotEmpty($productCategory->getImagePath()) ? $productCategory->getImagePath() : $productCategory->getID() . '.jpg';
        $path2productCategory = PRODUCT_CATEGORIES_PICTURES_ROOT . $productCategory->getID() . DS . $imagePath;
        if (!file_exists($path2productCategory)) {
            $imageData = $productCategory->getImage();
            if (isNotEmpty($imageData)) {
                //save image to file system to serve it from there next time
                self::saveImageContentToFile($path2productCategory, $imageData);
                return self::renderImageFromBlob($imageData, $imagePath);
            } else {
                return self::renderImageFromGallery($path2productCategory, 'blog_default.png');
            }
        } else {
            return PRODUCT_CATEGORIES_PICTURES_ROOT . $productCategory->getID() . DS . $imagePath;
        }
    }

    /**
     * @param Product $product
     * @return string
     * @throws SystemException
     */
    static function renderProductImage($product) {
        $imagePath = isNotEmpty($product->getImagePath()) ? $product->getImagePath() : $product->getID() . '.jpg';
        $path2product = PRODUCTS_PICTURES_ROOT . $product->getID() . DS . $imagePath;
        if (!file_exists($path2product)) {
            $imageData = $product->getImage();
            if (isNotEmpty($imageData)) {
                //save image to file system to serve it from there next time
                self::saveImageContentToFile($path2product, $imageData);
                return self::renderImageFromBlob($imageData, $imagePath);
            } else {
                return self::renderImageFromGallery($path2product, 'blog_default.png');
            }
        } else {
            return PRODUCTS_PICTURES_ROOT . $product->getID() . DS . $imagePath;
        }
    }

    /**
     * @param Post $post
     * @return string
     * @throws SystemException
     */
    static function renderBlogImage($post) {
        $imagePath = isNotEmpty($post->getImagePath()) ? $post->getImagePath() : $post->getID() . '.jpg';
        $path2post = POSTS_PICTURES_ROOT . $post->getID() . DS . $imagePath;
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
            return PICTURES_ROOT . $post->getID() . DS . $imagePath;
        }
    }

    /**
     * @param User $user
     * @return string
     * @throws SystemException
     */
    static function renderUserImage($user) {
        $imagePath = isNotEmpty($user->getPicturePath()) ? $user->getPicturePath() : $user->getUserName() . '.jpg';
        $path = USERS_PICTURES_ROOT . $user->getUserName() . DS . $imagePath;
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
     * @param $path string
     * @param $fallBack string
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

    /**
     * @param $path
     * @return string
     * @throws SystemException
     */
    static function renderGalleryImage($path) {
        return self::renderImageFromGallery($path, 'default.png');
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
     * @return bool|SimpleImage
     */
    static function readImageContentFromFile($tmpFile) {
        $tmpFileContent = $tmpFile[self::TMP_NAME];

        $image = new SimpleImage();
        $image->load($tmpFileContent);
        $image->resize(MAX_IMAGE_WIDTH, MAX_IMAGE_HEIGHT);

//        $imgContent = file_get_contents($tmpFileContent);
        return $image;
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
     * @param $entity string
     * @param $extraPath string
     * @param $fileName string
     * @param $tmpFile SimpleImage
     * @return bool
     */
    static function saveImageToFileSystem($entity, $extraPath, $fileName, $tmpFile) {
        $pathToSave = isNotEmpty($entity) ? $entity . DS : '';
        $pathToSave .= isNotEmpty($extraPath) ? $extraPath . DS : '';
        createDirIfNotExists($pathToSave);
        $pathToSave .= $fileName;
        return $tmpFile->save($pathToSave);
    }

    /**
     * @param $entity
     * @param null $path
     */
    static function removeImageFromFileSystem($entity, $path = null) {
        $pathToDel = isNotEmpty($entity) ? $entity : '';
        $pathToDel .= isNotEmpty($path) ? $path . '/' : '';
        if (file_exists($pathToDel)) {
            self::rrmdir($pathToDel);
        } else {
            //TODO : log warning here that path does not exist
        }
    }

    /**
     * Used to remove directory and subfiles recursively
     * @param $dir
     */
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