<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'events' . DS . 'EventStatus.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'events' . DS . 'DaysOfWeek.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'events' . DS . 'Event.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'events' . DS . 'Lesson.php');

class ProgramHandler
{
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

    const LESSON = 'LESSON';


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
     * @param $events Event[]
     * @return array
     */
    static function mobileProgram($events) {
        $mobileProgram = array();
        $mondayLessons = array();
        $tuesdayLessons = array();
        $wednesdayLessons = array();
        $thursdayLessons = array();
        $fridayLessons = array();
        $saturdayLessons = array();

        foreach ($events as $event) {
            switch ($event->getDay()) {
                case DaysOfWeek::MONDAY:
                    $mondayLessons[] = self::addMobileLesson($event->getStart(), $event->getEnd(), $event->getName());
                    break;
                case DaysOfWeek::TUESDAY:
                    $tuesdayLessons[] = self::addMobileLesson($event->getStart(), $event->getEnd(), $event->getName());
                    break;
                case DaysOfWeek::WEDNESDAY:
                    $wednesdayLessons[] = self::addMobileLesson($event->getStart(), $event->getEnd(), $event->getName());
                    break;
                case DaysOfWeek::THURSDAY:
                    $thursdayLessons[] = self::addMobileLesson($event->getStart(), $event->getEnd(), $event->getName());
                    break;
                case DaysOfWeek::FRIDAY:
                    $fridayLessons[] = self::addMobileLesson($event->getStart(), $event->getEnd(), $event->getName());
                    break;
                case DaysOfWeek::SATURDAY:
                    $saturdayLessons[] = self::addMobileLesson($event->getStart(), $event->getEnd(), $event->getName());
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
                    $lessons[$event->getDay() . '_' . $timeFrame] = $event->getName();
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
     * @param $start
     * @param $end
     * @param $lesson
     * @return array
     */
    static function addMobileLesson($start, $end, $lesson) {
        return array(TIME_FRAME => $start . '-' . $end, LESSON => $lesson);
    }

    /**
     * @param $day
     * @param $start
     * @param $end
     * @param $lesson
     * @param string $secondLesson
     * @return Event
     */
    static function addLesson($day, $start, $end, $lesson, $secondLesson = '') {
        $lessonStr = $lesson;
        if ($secondLesson !== '') {
            $lessonStr .= ' / ' . $secondLesson;
        }
        return Event::createEvent(null, $lessonStr, null, EventStatus::ACTIVE, $day, $start, $end);
    }

    /**
     * @return Event[]|bool
     * @throws SystemException
     */
    static function fetchEvents() {
        $query = "SELECT * FROM " . getDb()->events;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateProgram($rows);
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
            ") VALUES (?,?,?,?,?,?)";
        $createdEvent = getDb()->createStmt($query,
            array('s', 's', 'i', 's', 's', 's'),
            array($event->getName(), $event->getDescription(), $event->getStatus(), $event->getDay(), $event->getStart(), $event->getEnd()));
        return $createdEvent;
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
     * @param $lesson
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function deleteLesson($lesson) {
        $query = "DELETE FROM " . getDb()->lessons . " WHERE " . self::LESSON . " = ?";
        $createdLesson = getDb()->createStmt($query, array('s'), array($lesson));
        return $createdLesson;
    }

    /*Populate Functions*/
    /**
     * @param $rows
     * @return Event[]|bool
     */
    private static function populateProgram($rows) {
        if ($rows === false) {
            return false;
        }

        $days = [];

        foreach ($rows as $row) {
            $day
                = self::populateDays($row);
            $days[] = $day;
        }
        return $days;
    }

    /**
     * @param $row
     * @return Event|bool
     */
    private static function populateDays($row) {
        if ($row === false) {
            return false;
        }
        return Event::createEvent($row[self::ID], $row[self::NAME], $row[self::DESCRIPTION], $row[self::STATUS], $row[self::DAY], $row[self::START], $row[self::END]);
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