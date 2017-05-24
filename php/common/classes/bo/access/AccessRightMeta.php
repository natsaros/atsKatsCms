<?php

/**
 * Holds meta data of access right
 */
class AccessRightMeta {
    private $ID;
    private $acc_id;
    private $meta_key;
    private $meta_value;

    /**
     * AccessRightMeta constructor.
     */
    public function __construct() {
    }

    /**
     * @return AccessRightMeta
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }


    /**
     * @param $ID
     * @param $acc_id
     * @param $key
     * @param $value
     * @return $this
     */
    public static function createMeta($ID, $acc_id, $key, $value) {
        return self::create()->setID($ID)->setAccId($acc_id)->setMetaKey($key)->setMetaValue($value);
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
    public function getAccId() {
        return $this->acc_id;
    }

    /**
     * @param mixed $acc_id
     * @return $this
     */
    public function setAccId($acc_id) {
        $this->acc_id = $acc_id;
        return $this;
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