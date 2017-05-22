<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'groups' . DS . 'GroupStatus.php');

/**
 * Signifies user groups of the application
 */
class Group {
    private $ID;
    private $name;
    private $status;

    /**
     * @var GroupMeta[]
     */
    private $groupMeta;

    /**
     * Group constructor.
     */
    public function __construct() {
        $this->setStatus(GroupStatus::ACTIVE);
    }

    /**
     * @return Group
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }

    public static function createGroup($ID, $name, $status) {
        return self::create()->setID($ID)->setName($name)->setStatus($status);
    }

    /**
     * @param mixed $ID
     * @return $this
     */
    public function setID($ID) {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @param boolean $status
     * @return $this
     */
    public function setStatus($status) {
        $this->status = $status ? 1 : 0;
        return $this;
    }

    /**
     * @param mixed $groupMeta
     * @return $this
     */
    public function setGroupMeta($groupMeta) {
        $this->groupMeta = $groupMeta;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getID() {
        return $this->ID;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return GroupMeta[]
     */
    public function getGroupMeta() {
        return $this->groupMeta;
    }

    /**
     * @return boolean
     */
    public function getStatus() {
        return $this->status === 1;
    }

}