<?php

class SimpleImage {
    var $image;
    var $image_type;

    function load($filename) {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if($this->image_type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif($this->image_type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        } elseif($this->image_type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        }
    }

    function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = null) {
        $saved = false;
        if($image_type == IMAGETYPE_JPEG) {
            $saved = imagejpeg($this->image, $filename, $compression);
        } elseif($image_type == IMAGETYPE_GIF) {
            $saved = imagegif($this->image, $filename);
        } elseif($image_type == IMAGETYPE_PNG) {
            $saved = imagepng($this->image, $filename);
        }
        if($permissions != null) {
            $saved = chmod($filename, $permissions);
        }

        return $saved;
    }

    function output($image_type = IMAGETYPE_JPEG) {
        if($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image);
        } elseif($image_type == IMAGETYPE_GIF) {
            imagegif($this->image);
        } elseif($image_type == IMAGETYPE_PNG) {
            imagepng($this->image);
        }
    }

    function getWidth() {
        return imagesx($this->image);
    }

    function getHeight() {
        return imagesy($this->image);
    }

    function resizeToHeight($height) {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height);
    }

    function resizeToWidth($width) {
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width, $height);
    }

    function scale($scale) {
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;
        $this->resize($width, $height);
    }

    function resize($width, $height) {
        $old_w = $this->getWidth();
        $old_h = $this->getHeight();

        $ratio_orig = $old_w / $old_h;
        if($width / $height > $ratio_orig) {
            $width = $height * $ratio_orig;
        } else {
            $height = $width / $ratio_orig;
        }

        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $old_w, $old_h);
        $this->image = $new_image;
    }
}