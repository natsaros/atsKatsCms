<?php

class PathHelper {

    /**
     * @param $path
     * @return string
     */
    static function getParentPath($path) {
        return dirname($path);
    }

}