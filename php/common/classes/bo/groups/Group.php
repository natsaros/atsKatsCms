<?php

/**
 * Signifies user groups of the application
 */
class Group {
    private $ID;
    private $name;

    /**
     * @var GroupMeta[]
     */
    private $groupMeta;

    /**
     * Group constructor.
     */
    public function __construct() {

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

}