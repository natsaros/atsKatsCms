<?php

class Globals {

    /**
     * @param $name
     * @param $value
     * @throws SystemException
     */
    static public function set($name, $value) {
        $GLOBALS[self::getPrefix() . $name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     * @throws SystemException
     */
    static public function get($name) {
        return $GLOBALS[self::getPrefix() . $name];
    }

    /**
     * @return string
     * @throws SystemException
     */
    static private function getPrefix() {
        $prefix = '_';
        if(!is_null(TABLE_PREFIX)) {
            $prefix = TABLE_PREFIX;
        }
        return $prefix;
    }
}

?>