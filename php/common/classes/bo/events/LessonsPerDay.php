<?php

class LessonsPerDay implements JsonSerializable
{

    private $day;
    private $count;

    /**
     * LessonsPerDay constructor.
     */
    public function __construct() {

    }

    /**
     * @return LessonsPerDay
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }

    /**
     * @param $day
     * @param $count
     * @return $this
     */
    public static function createLessonsPerDay($day, $count) {
        return self::create()
            ->setDay($day)
            ->setCount($count);
    }

    /**
     * @return mixed
     */
    public function getDay() {
        return isNotEmpty($this->day) ? $this->day : '';
    }

    /**
     * @param mixed $day
     * @return LessonsPerDay
     */
    public function setDay($day) {
        $this->day = $day;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCount() {
        return $this->count;
    }

    /**
     * @param mixed $count
     * @return LessonsPerDay
     */
    public function setCount($count) {
        $this->count = $count;
        return $this;
    }

    public function jsonSerialize() {
        return [
            'day' => $this->getDay(),
            'count' => $this->getCount()
        ];
    }
}