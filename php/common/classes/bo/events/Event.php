<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'events' . DS . 'EventStatus.php');

class Event implements JsonSerializable {

    private $ID;
    private $name;
    private $status;

    private $day;
    private $start;
    private $end;

    /**
     * Event constructor.
     */
    public function __construct() {
        $this->setStatus(EventStatus::ACTIVE);
    }

    /**
     * @return Event
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }

    /**
     * @param $ID
     * @param $name
     * @param $status
     * @param $day
     * @param $start
     * @param $end
     * @return $this
     */
    public static function createEvent($ID, $name, $status, $day, $start, $end) {
        return self::create()
            ->setID($ID)
            ->setName($name)
            ->setStatus($status)
            ->setDay($day)
            ->setStart($start)
            ->setEnd($end);
    }

    /**
     * @return mixed
     */
    public function getID() {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     * @return Event
     */
    public function setID($ID) {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Event
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Event
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStart() {
        return $this->start;
    }

    /**
     * @param mixed $start
     * @return Event
     */
    public function setStart($start) {
        $this->start = $start;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEnd() {
        return $this->end;
    }

    /**
     * @param mixed $end
     * @return Event
     */
    public function setEnd($end) {
        $this->end = $end;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDay() {
        return $this->day;
    }

    /**
     * @param mixed $day
     * @return Event
     */
    public function setDay($day) {
        $this->day = $day;
        return $this;
    }

    public function jsonSerialize() {
        return [
            'title' => $this->getName(),
            'day' => $this->getDay(),
            'start' => $this->getEnd(),
            'end' => $this->getEnd(),
            'status' => $this->getStatus()
        ];
    }
}