<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'events' . DS . 'EventStatus.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'events' . DS . 'DaysOfWeek.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'events' . DS . 'Event.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'events' . DS . 'Lesson.php');

class ProgramHandler {
    const PILATES_EQUIP = 'Pilates equipment';
    const YOGA = 'Yoga';
    const PILATES_MAT = 'Pilates mat';
    const FAT_BURN = 'Fat burn';
    const AERIAL_YOGA = 'Aerial yoga';

    const ID = 'ID';
    const NAME = 'NAME';
    const DESCRIPTION = 'DESCRIPTION';
    const STATUS = 'STATUS';
    const DAY = 'DAY';

    const START = 'START_TIME';
    const END = 'END_TIME';
    const PLACE = 'PLACE';

    const LESSON = 'LESSON';
    const OWNER = 'OWNER';


    /**
     * @return bool|Lesson[]
     * @throws SystemException
     */
    static function fetchLessons() {
        $query = "SELECT * FROM " . getDb()->lessons;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateLessons($rows);
    }

    /**
     * @param $id
     * @return bool|Lesson
     * @throws SystemException
     */
    static function getLessonById($id) {
        if (isNotEmpty($id)) {
            $query = "SELECT * FROM " . getDb()->lessons . " WHERE " . self::ID . " = ? ";
            $row = getDb()->selectStmtSingle($query, array('i'), array($id));
            return self::populateLesson($row);
        }
        return null;
    }

    /**
     * @param $events Event[]
     * @return array
     */
    static function mobileProgram($events) {
        $mobileProgram = array();

        $mondayLessons = array();
        $mondayTimeFrames = array();

        $tuesdayLessons = array();
        $tuesdayTimeFrames = array();

        $wednesdayLessons = array();
        $wednesdayTimeFrames = array();

        $thursdayLessons = array();
        $thursdayTimeFrames = array();

        $fridayLessons = array();
        $fridayTimeFrames = array();

        $saturdayLessons = array();
        $saturdayTimeFrames = array();

        foreach ($events as $event) {
            $timeFrame = $event->getStart() . '-' . $event->getEnd();

            switch ($event->getDay()) {
                case DaysOfWeek::MONDAY:
                    $lesson2add = self::addMobileLesson($timeFrame, $event->getName(), $mondayTimeFrames, $mondayLessons);
                    if (isNotEmpty($lesson2add)) {
                        $mondayLessons[] = $lesson2add;
                    }
                    $mondayTimeFrames[] = $timeFrame;
                    break;
                case DaysOfWeek::TUESDAY:
                    $lesson2add = self::addMobileLesson($timeFrame, $event->getName(), $tuesdayTimeFrames, $tuesdayLessons);
                    if (isNotEmpty($lesson2add)) {
                        $tuesdayLessons[] = $lesson2add;
                    }
                    $tuesdayTimeFrames[] = $timeFrame;
                    break;
                case DaysOfWeek::WEDNESDAY:
                    $lesson2add = self::addMobileLesson($timeFrame, $event->getName(), $wednesdayTimeFrames, $wednesdayLessons);
                    if (isNotEmpty($lesson2add)) {
                        $wednesdayLessons[] = $lesson2add;
                    }
                    $wednesdayTimeFrames[] = $timeFrame;
                    break;
                case DaysOfWeek::THURSDAY:
                    $lesson2add = self::addMobileLesson($timeFrame, $event->getName(), $thursdayTimeFrames, $thursdayLessons);
                    if (isNotEmpty($lesson2add)) {
                        $thursdayLessons[] = $lesson2add;
                    }
                    $thursdayTimeFrames[] = $timeFrame;
                    break;
                case DaysOfWeek::FRIDAY:
                    $lesson2add = self::addMobileLesson($timeFrame, $event->getName(), $fridayTimeFrames, $fridayLessons);
                    if (isNotEmpty($lesson2add)) {
                        $fridayLessons[] = $lesson2add;
                    }
                    $fridayTimeFrames[] = $timeFrame;
                    break;
                case DaysOfWeek::SATURDAY:
                    $lesson2add = self::addMobileLesson($timeFrame, $event->getName(), $saturdayTimeFrames, $saturdayLessons);
                    if (isNotEmpty($lesson2add)) {
                        $saturdayLessons[] = $lesson2add;
                    }
                    $saturdayTimeFrames[] = $timeFrame;
                    break;
            }
        }

        $mobileProgram[DaysOfWeek::MONDAY] = $mondayLessons;
        $mobileProgram[DaysOfWeek::TUESDAY] = $tuesdayLessons;
        $mobileProgram[DaysOfWeek::WEDNESDAY] = $wednesdayLessons;
        $mobileProgram[DaysOfWeek::THURSDAY] = $thursdayLessons;
        $mobileProgram[DaysOfWeek::FRIDAY] = $fridayLessons;
        $mobileProgram[DaysOfWeek::SATURDAY] = $saturdayLessons;
        return $mobileProgram;
    }

    /**
     * @param $events Event[]
     * @return array
     */
    static function desktopProgram($events) {
        $lessons = array();
        $timeFrames = self::getTimeFrames($events);
        foreach ($events as $event) {
            $timeFrame = $event->getStart() . '-' . $event->getEnd();
            switch ($timeFrame) {
                case $timeFrames[$timeFrame] :
                    $timeSpace = $event->getDay() . '_' . $timeFrame;
                    $key = array_search($timeSpace, array_keys($lessons));
                    if ($key !== false) {
                        $lessons[$timeSpace] = $lessons[$timeSpace] . ' / ' . $event->getName();
                    } else {
                        $lessons[$timeSpace] = $event->getName();
                    }
                    break;
            }
        }

        return $lessons;
    }

    /**
     * @param $events Event[]
     * @return array
     */
    static function getTimeFrames($events) {
        $timeFrames = array();
        foreach ($events as $event) {
            $timeFrame = $event->getStart() . '-' . $event->getEnd();
            $timeFrames[$timeFrame] = $timeFrame;
        }
        ksort($timeFrames);
        return $timeFrames;
    }

    /**
     * @param $timeFrame string
     * @param $lesson string
     * @param $daysTimeFrames array
     * @param $daysLessons array
     * @return array
     */
    static function addMobileLesson($timeFrame, $lesson, $daysTimeFrames, &$daysLessons) {
        $lesson2Add = array(TIME_FRAME => $timeFrame, LESSON => $lesson);
        $key = array_search($timeFrame, $daysTimeFrames);
        if ($key !== false) {
            $foundLesson = $daysLessons[$key];
            $foundLesson['lesson'] .= ' / ' . $lesson;
            $daysLessons[$key] = $foundLesson;
            return null;
        } else {
            return $lesson2Add;
        }
    }

    /**
     * @return Event[]|bool
     * @throws SystemException
     */
    static function fetchEvents() {
        $query = "SELECT * FROM " . getDb()->events;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateEvents($rows);
    }

    /**
     * @return Event[]|bool
     * @throws SystemException
     */
    static function fetchActiveEvents() {
        $query = "SELECT * FROM " . getDb()->events . " WHERE " . self::STATUS . " = " . EventStatus::ACTIVE;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateEvents($rows);
    }

    /**
     * @param $id
     * @return Event
     * @throws SystemException
     */
    static function fetchEventById($id) {
        if (isNotEmpty($id)) {
            $query = "SELECT * FROM " . getDb()->events . " WHERE " . self::ID . " = ?";
            $row = getDb()->selectStmtSingle($query, array('i'), array($id));
            if ($row) {
                return self::populateEvent($row);
            }
            return null;
        }
        return null;
    }

    /**
     * @param $events Event[]
     * @throws SystemException
     */
    public static function addDbEvents($events) {
        foreach ($events as $event) {
            self::addDbEvent($event);
        }
    }

    /**
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function deleteDBEvents() {
        $query = "DELETE FROM " . getDb()->events;
        $createdLesson = getDb()->deleteStmt($query);
        return $createdLesson;
    }

    /**
     * @param $ID
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function deleteDBEvent($ID) {
        if (isNotEmpty($ID)) {
            $query = "DELETE FROM " . getDb()->events . " WHERE " . self::ID . " = ?";
            $createdLesson = getDb()->deleteStmt($query, array('s'), array($ID));
            return $createdLesson;
        } else {
            return null;
        }
    }

    /**
     * @param $event Event
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function addDBEvent($event) {
        $query = "INSERT INTO " . getDb()->events .
            "(" . self::NAME .
            "," . self::DESCRIPTION .
            "," . self::STATUS .
            "," . self::DAY .
            "," . self::START .
            "," . self::END .
            "," . self::PLACE .
            "," . self::OWNER .
            ") VALUES (?,?,?,?,?,?,?,?)";
        $createdEvent = getDb()->createStmt($query,
            array('s', 's', 'i', 's', 's', 's', 's', 's'),
            array($event->getName(), $event->getDescription(), $event->getStatus(), $event->getDay(), $event->getStart(), $event->getEnd(), $event->getOwner(), $event->getPlace()));
        return $createdEvent;
    }

    /**
     * @param $event Event
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function updateDBEvent($event) {
        $query = "UPDATE " . getDb()->events .
            " SET "
            . self::NAME . " = ?, "
            . self::DESCRIPTION . " = ?, "
            . self::STATUS . " = ?, "
            . self::DAY . " = ?, "
            . self::START . " = ?, "
            . self::END . " = ?, "
            . self::OWNER . " = ?, "
            . self::PLACE . " = ?"
            . " WHERE "
            . self::ID . "= ?";
        $updatedEvent = getDb()->updateStmt($query,
            array('s', 's', 'i', 's', 's', 's', 's', 's', 'i'),
            array($event->getName(), $event->getDescription(), $event->getStatus(), $event->getDay(), $event->getStart(), $event->getEnd(), $event->getOwner(), $event->getPlace(), $event->getID()));
        return $updatedEvent;
    }

    /**
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function saveDBEvents() {
        $query = "UPDATE " . getDb()->events .
            " SET "
            . self::STATUS . " = ?"
            . " WHERE "
            . self::STATUS . " = ?";
        $updatedEvent = getDb()->updateStmt($query,
            array('s', 's'),
            array(EventStatus::ACTIVE, EventStatus::INACTIVE));
        return $updatedEvent;
    }

    /**
     * @param $lesson
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function addDBLesson($lesson) {
        $query = "INSERT INTO " . getDb()->lessons . " (" . self::LESSON . ") VALUES (?)";
        $createdLesson = getDb()->createStmt($query, array('s'), array($lesson));
        return $createdLesson;
    }

    /**
     * @param $ID
     * @param $lesson
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function editLesson($ID, $lesson) {
        $query = "UPDATE " . getDb()->lessons . " SET " . self::LESSON . " = ? WHERE " . self::ID . "= ?";
        $editedLesson = getDb()->createStmt($query, array('s', 'i'), array($lesson, $ID));
        return $editedLesson;
    }

    /**
     * @param $lessonID
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function deleteLesson($lessonID) {
        if (isNotEmpty($lessonID)) {
            $query = "DELETE FROM " . getDb()->lessons . " WHERE " . self::ID . " = ?";
            $createdLesson = getDb()->deleteStmt($query, array('s'), array($lessonID));
            return $createdLesson;
        } else {
            return null;
        }
    }

    /*Populate Functions*/
    /**
     * @param $rows
     * @return Event[]|bool
     */
    private static function populateEvents($rows) {
        if ($rows === false) {
            return false;
        }

        $days = [];

        foreach ($rows as $row) {
            $day
                = self::populateEvent($row);
            $days[] = $day;
        }
        return $days;
    }

    /**
     * @param $row
     * @return Event|bool
     */
    private static function populateEvent($row) {
        if ($row === false) {
            return false;
        }
        return Event::createEvent($row[self::ID], $row[self::NAME], $row[self::DESCRIPTION], $row[self::STATUS], $row[self::DAY], $row[self::START], $row[self::END], $row[self::OWNER], $row[self::PLACE]);
    }


    /**
     * @param $rows
     * @return Lesson[]|bool
     */
    private static function populateLessons($rows) {
        if ($rows === false) {
            return false;
        }

        $lessons = [];

        foreach ($rows as $row) {
            $lesson = self::populateLesson($row);
            $lessons[] = $lesson;
        }
        return $lessons;
    }

    /**
     * @param $row
     * @return Lesson|bool
     */
    private static function populateLesson($row) {
        if ($row === false) {
            return false;
        }
        return Lesson::createLesson($row[self::ID], $row[self::LESSON], $row[self::STATUS]);
    }
}