<?php

class Globals {

    static public function set($name, $value) {

        $GLOBALS[self::getPrefix() . $name] = $value;
    }

    static public function get($name) {
        return $GLOBALS[self::getPrefix() . $name];
    }

    static private function getPrefix() {
        $prefix = '_';
        if(!is_null(TABLE_PREFIX)) {
            $prefix = TABLE_PREFIX;
        }
        return $prefix;
    }
}

?>