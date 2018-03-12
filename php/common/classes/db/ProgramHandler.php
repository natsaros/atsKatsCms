<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'events' . DS . 'Event.php');

class ProgramHandler {

    const ID = 'ID';
    const NAME = 'NAME';
    const STATUS = 'STATUS';



    /**
     * @return Event[]|bool
     * @throws SystemException
     */
    static function fetchProgram() {
        $rows = array();
        return self::populateProgram($rows);
    }

    /*Populate Functions*/

    /**
     * @param $rows
     * @return Event[]|bool
     * @throws SystemException
     */
    private static function populateProgram($rows) {
        if ($rows === false) {
            return false;
        }

        $groups = [];

        foreach ($rows as $row) {
            $group = self::populateDays($row);
            $groups[] = $group;
        }
        return $groups;
    }

    /**
     * @param $row
     * @return Event|bool
     * @throws SystemException
     */
    private static function populateDays($row) {
        if ($row === false) {
            return false;
        }
        return Event::createEvent($row[self::ID], $row[self::GROUP_NAME], $row[self::STATUS]);
    }
}