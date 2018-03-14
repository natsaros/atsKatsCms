<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'events' . DS . 'Event.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'events' . DS . 'EventStatus.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'events' . DS . 'DaysOfWeek.php');

class ProgramHandler {
    const ID = 'ID';
    const NAME = 'NAME';
    const STATUS = 'STATUS';

    const DAY = 'DAY';
    const START = 'START';
    const END = 'END';

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
        return Event::createEvent(null, $lessonStr, EventStatus::ACTIVE, $day, $start, $end);
    }

    /**
     * @return Event[]|bool
     */
    static function fetchEvents() {
        $rows = array();
        $rows[] = self::addLesson(DaysOfWeek::MONDAY, '08:30', '09:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::MONDAY, '09:30', '10:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::MONDAY, '10:30', '11:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::MONDAY, '11:30', '12:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::MONDAY, '13:00', '14:00', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::MONDAY, '16:00', '17:00', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::MONDAY, '17:00', '18:00', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::MONDAY, '18:00', '19:00', PILATES_MAT);
        $rows[] = self::addLesson(DaysOfWeek::MONDAY, '19:00', '20:00', FAT_BURN);
        $rows[] = self::addLesson(DaysOfWeek::MONDAY, '20:00', '21:00', YOGA);
        $rows[] = self::addLesson(DaysOfWeek::MONDAY, '21:00', '22:00', PILATES_EQUIP);

        $rows[] = self::addLesson(DaysOfWeek::TUESDAY, '08:30', '09:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::TUESDAY, '09:00', '10:00', YOGA);
        $rows[] = self::addLesson(DaysOfWeek::TUESDAY, '09:30', '10:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::TUESDAY, '10:30', '11:30', PILATES_MAT);
        $rows[] = self::addLesson(DaysOfWeek::TUESDAY, '11:30', '12:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::TUESDAY, '16:00', '17:00', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::TUESDAY, '17:00', '18:00', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::TUESDAY, '18:00', '19:00', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::TUESDAY, '19:00', '20:00', PILATES_MAT);
        $rows[] = self::addLesson(DaysOfWeek::TUESDAY, '20:00', '21:00', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::TUESDAY, '21:00', '22:00', PILATES_EQUIP);

        $rows[] = self::addLesson(DaysOfWeek::WEDNESDAY, '08:30', '09:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::WEDNESDAY, '09:30', '10:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::WEDNESDAY, '10:00', '11:00', FAT_BURN);
        $rows[] = self::addLesson(DaysOfWeek::WEDNESDAY, '10:30', '11:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::WEDNESDAY, '13:00', '14:00', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::WEDNESDAY, '16:00', '17:00', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::WEDNESDAY, '17:00', '18:00', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::WEDNESDAY, '18:00', '19:00', PILATES_MAT);
        $rows[] = self::addLesson(DaysOfWeek::WEDNESDAY, '19:00', '20:00', FAT_BURN);
        $rows[] = self::addLesson(DaysOfWeek::WEDNESDAY, '20:00', '21:00', PILATES_MAT, AERIAL_YOGA);
        $rows[] = self::addLesson(DaysOfWeek::WEDNESDAY, '21:00', '22:00', PILATES_EQUIP);

        $rows[] = self::addLesson(DaysOfWeek::THURSDAY, '08:30', '09:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::THURSDAY, '09:30', '10:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::THURSDAY, '10:30', '11:30', PILATES_MAT);
        $rows[] = self::addLesson(DaysOfWeek::THURSDAY, '17:00', '18:00', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::THURSDAY, '18:00', '19:00', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::THURSDAY, '19:00', '20:00', YOGA);
        $rows[] = self::addLesson(DaysOfWeek::THURSDAY, '20:00', '21:00', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::THURSDAY, '21:00', '22:00', PILATES_EQUIP);

        $rows[] = self::addLesson(DaysOfWeek::FRIDAY, '08:30', '09:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::FRIDAY, '09:30', '10:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::FRIDAY, '10:30', '11:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::FRIDAY, '11:30', '12:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::FRIDAY, '16:00', '17:00', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::FRIDAY, '17:00', '18:00', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::FRIDAY, '19:00', '20:00', PILATES_MAT);
        $rows[] = self::addLesson(DaysOfWeek::FRIDAY, '20:00', '21:00', PILATES_EQUIP);

        $rows[] = self::addLesson(DaysOfWeek::SATURDAY, '10:30', '11:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::SATURDAY, '11:30', '12:30', PILATES_EQUIP);
        $rows[] = self::addLesson(DaysOfWeek::SATURDAY, '13:00', '14:00', PILATES_MAT, AERIAL_YOGA);

//        return self::populateProgram($rows);
        return $rows;
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
     */
    private static function populateDays($row) {
        if ($row === false) {
            return false;
        }
        return Event::createEvent($row[self::ID], $row[self::NAME], $row[self::STATUS], $row[self::DAY], $row[self::START], $row[self::END]);
    }
}