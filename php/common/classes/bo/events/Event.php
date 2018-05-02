<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'events' . DS . 'EventStatus.php');

class Event implements JsonSerializable {

    private $ID;
    private $name;
    private $description;
    private $status;

    private $day;
    private $start;
    private $end;

    /**
     * Event constructor.
     */
    public function __construct() {
        $this->setStatus(EventStatus::INACTIVE);
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
     * @param $description
     * @param $status
     * @param $day
     * @param $start
     * @param $end
     * @return $this
     */
    public static function createEvent($ID, $name, $description, $status, $day, $start, $end) {
        return self::create()
            ->setID($ID)
            ->setName($name)
            ->setDescription($description)
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
    public function getDescription() {
        return isNotEmpty($this->description) ? $this->description : '';
    }

    /**
     * @param mixed $description
     * @return Event
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus() {
        return isNotEmpty($this->status) ? $this->status : '';
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
        return isNotEmpty($this->day) ? $this->day : '';
    }

    /**
     * @param mixed $day
     * @return Event
     */
    public function setDay($day) {
        $this->day = $day;
        return $this;
    }

    /**
     * @param $day
     * @param $time
     * @return false|string
     */
    private function getTimeAndMinutes($day, $time) {
        //TODO : fix issue when it is sunday
        //if current day is sunday get next weeks date to complete the calendar
//        $whichWeek = '0';
//        if ((date('D') === 'Sun')) {
//            $whichWeek = '1';
//        }
        $date = new DateTime(date('Y-m-d', strtotime("{$day} this week midnight")));
        $explodeTime = explode(':', $time);
        $hoursToAdd = $explodeTime[0];
        $date->modify("+{$hoursToAdd} hours");

        $minutesToAdd = $explodeTime[1];
        $date->modify("+{$minutesToAdd} minutes");
        return $date->format('Y-m-d H:i:s');
    }

    public function jsonSerialize() {
        $start = self::getTimeAndMinutes($this->getDay(), $this->getStart());
        $end = self::getTimeAndMinutes($this->getDay(), $this->getEnd());
        return [
            'id' => $this->getID(),
            'title' => $this->getName(),
            'description' => $this->getDescription(),
            'day' => $this->getDay(),
            'start' => $start,
            'end' => $end,
            'status' => $this->getStatus()
        ];
    }
}