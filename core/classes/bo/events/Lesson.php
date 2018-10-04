<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'events' . DS . 'EventStatus.php');

class Lesson {

    private $ID;
    private $name;
    private $status;


    /**
     * Lesson constructor.
     */
    public function __construct() {
        $this->setStatus(EventStatus::ACTIVE);
    }

    /**
     * @return Lesson
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }

    /**
     * @param $ID
     * @param $name
     * @param $status
     * @return $this
     */
    public static function createLesson($ID, $name, $status) {
        return self::create()
            ->setID($ID)
            ->setName($name)
            ->setStatus($status);
    }

    /**
     * @return mixed
     */
    public function getID() {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     * @return Lesson
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
     * @return Lesson
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
     * @return Lesson
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }
}