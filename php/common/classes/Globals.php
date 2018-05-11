<?php

class Globals
{

    /**
     * @param $name
     * @param $value
     */
    static public function set($name, $value) {
        $GLOBALS[self::getPrefix() . $name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    static public function get($name) {
        if (isset($GLOBALS[self::getPrefix() . $name])) {
            return $GLOBALS[self::getPrefix() . $name];
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    static private function getPrefix() {
        $prefix = '_';
        if (!is_null(TABLE_PREFIX)) {
            $prefix = TABLE_PREFIX;
        }
        return $prefix;
    }
}

?>