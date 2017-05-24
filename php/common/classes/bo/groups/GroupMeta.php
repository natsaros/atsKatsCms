<?php

/**
 * Holds meta data of group
 */
class GroupMeta {

    const DESCRIPTION = 'description';

    private $ID;
    private $group_id;
    private $meta_key;
    private $meta_value;

    /**
     * GroupMeta constructor.
     */
    public function __construct() {
    }

    /**
     * @return GroupMeta
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }

    /**
     * @param $ID
     * @param $groupID
     * @param $key
     * @param $value
     * @return $this
     */
    public static function createMeta($ID, $groupID, $key, $value) {
        return self::create()->setID($ID)->setGroupId($groupID)->setMetaKey($key)->setMetaValue($value);
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
    public function getGroupId() {
        return $this->group_id;
    }

    /**
     * @return mixed
     */
    public function getMetaKey() {
        return $this->meta_key;
    }

    /**
     * @return mixed
     */
    public function getMetaValue() {
        return $this->meta_value;
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
     * @param mixed $group_id
     * @return $this
     */
    public function setGroupId($group_id) {
        $this->group_id = $group_id;
        return $this;
    }

    /**
     * @param mixed $meta_key
     * @return $this
     */
    public function setMetaKey($meta_key) {
        $this->meta_key = $meta_key;
        return $this;
    }

    /**
     * @param mixed $meta_value
     * @return $this
     */
    public function setMetaValue($meta_value) {
        $this->meta_value = $meta_value;
        return $this;
    }

}